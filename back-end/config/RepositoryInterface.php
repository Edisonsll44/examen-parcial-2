<?php
interface RepositoryInterface {
    public function findAll();
    public function findById($id);
    public function create($object);
    public function update($id,$object);
    public function delete($id);
}
