<?php

namespace App\Controllers;

use App\Libraries\ColumnLib;
use App\Libraries\TableLib;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */

    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';
    public function index()
    {


        $order = $this->request->getVar('order');
        $order = array_shift($order);

        $modelList = model('UserModel');
        $tableLib = new TableLib($modelList, 'User', [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ]);
        $response = $tableLib->getResponse([
            'draw' => $this->request->getVar('draw'),
            'start' => $this->request->getVar('start'),
            'length' => $this->request->getVar('length'),
            'order' => $order['column'],
            'direction' => $order['dir'],
            'search' => $this->request->getVar('search')['value']
        ]);



        return $this->respond($response);
    }


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'address' => 'required',
            'image' => 'uploaded[image]|max_size[image,20480]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // process upload
        $image = $this->request->getFile('image');
        $image->move(ROOTPATH . 'public/uploads');
        $imgName = $image->getName();


        $this->model->insert([
            'name' => esc($this->request->getVar('name')),
            'email' => esc($this->request->getVar('email')),
            'address' => esc($this->request->getVar('address')),
            'image' => $imgName
        ]);

        


        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Create user complete!',

            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'address' => 'required',
            'image' => 'uploaded[image]|max_size[image,20480]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // process upload
        $image = $this->request->getFile('image');
        $oldImage = esc($this->request->getVar('oldImage'));
        if ($image) {
            $imgName = $image->getName();
            $image->move(ROOTPATH . 'public/uploads');

            $imageDB = $this->model->find($id);
            if ($imageDB['image'] === $oldImage) {
                // remove old image in folder
                unlink(ROOTPATH . 'public/uploads/' . $oldImage);
            }
        } else {
            $imgName = $oldImage;
        }



        $this->model->update($id, [
            'name' => esc($this->request->getVar('name')),
            'email' => esc($this->request->getVar('email')),
            'address' => esc($this->request->getVar('address')),
            'image' => $imgName
        ]);

        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Update data success',
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {

        $imageDB = $this->model->find($id);
        if ($imageDB['image'] != "") {
            // remove old image in folder
            unlink(ROOTPATH . 'public/uploads/' . $imageDB['image']);
        }
        $this->model->delete($id);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Delete data success'
            ]
        ];
        return $this->respondDeleted($response);
    }
}
