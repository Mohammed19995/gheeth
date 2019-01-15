<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 14/07/18
 * Time: 05:45 م
 */
namespace App\Http\Custom;

interface RepositoryInterface {
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}