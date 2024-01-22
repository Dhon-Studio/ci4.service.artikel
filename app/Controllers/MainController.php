<?php

namespace App\Controllers;

use App\Models\Content;
use App\Models\ContentHeader;
use App\Models\Main;
use App\Models\Result;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Ramsey\Uuid\Uuid;

class MainController extends ResourceController
{
    /**
     * @var \App\Models\Main
     */
    protected $model;

    /**
     * @var \App\Models\ContentHeader
     */
    protected $modelHeader;

    /**
     * @var \App\Models\Content
     */
    protected $modelContent;

    /**
     * @var \App\Models\Result
     */
    protected $result;

    public function __construct()
    {
        $this->model = new Main();
        $this->modelHeader = new ContentHeader();
        $this->modelContent = new Content();
        $this->result = new Result();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $result = $this->model->findAll();

        foreach ($result as $key => $value) {
            $result[$key]['content'] = $this->modelHeader->where('id_main', $value['id'])->orderBy('created_at', 'asc')->findAll();

            foreach ($result[$key]['content'] as $k_c => $c) {
                $result[$key]['content'][$k_c]['content'] = $this->modelContent->where('id_header', $c['id'])->orderBy('created_at', 'asc')->findAll();
            }
        }

        $this->result->Data = $result;

        return $this->respond($this->result);
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        try {
            $post = $this->request->getPost();
            $exist = $this->model->where('anchor', $post['anchor'])->first();

            if (!$exist) {
                $mdata = $post;
                $mdata['id'] = Uuid::uuid4();
                unset($mdata['header']);
                unset($mdata['content']);
                $id = $this->model->insert($mdata);

                foreach (explode(';', $post['header']) as $k_h => $h) {
                    $data['id'] = Uuid::uuid4();
                    $data['header'] = $h;
                    $data['id_main'] = $id;
                    $hid = $this->modelHeader->insert($data);

                    $content = explode('[]', $post['content']);
                    foreach (explode('||', $content[$k_h]) as $k_c => $c) {
                        $cdata['id'] = Uuid::uuid4();
                        $cdata['content'] = $c;
                        $cdata['id_main'] = $id;
                        $cdata['id_header'] = $hid;
                        $this->modelContent->insert($cdata);
                        sleep(1);
                    }
                    sleep(1);
                }

                $this->result->Data = $this->model->where('id', $id)->first();
                $this->result->Data['content'] = $this->modelHeader->where('id_main', $id)->findAll();
                foreach ($this->result->Data['content'] as $key => $value) {
                    $this->result->Data['content'][$key]['content'] = $this->modelContent->where('id_header', $value['id'])->findAll();
                }

                return $this->respond($this->result);
            } else {
                return $this->failForbidden('Sudah pernah dipublish');
            }
        } catch (\Throwable $th) {
            return $this->failForbidden($th->getMessage());
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        try {
            $this->modelContent->where('id_main', $id)->delete();
            $this->modelHeader->where('id_main', $id)->delete();
            $this->model->delete($id);

            return $this->respondDeleted();
        } catch (\Throwable $th) {
            return $this->failForbidden();
        }
    }
}
