<?php
return array (
  'createNote' => 
  array (
    'type' => 0,
    'description' => 'create a note',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readNote' => 
  array (
    'type' => 0,
    'description' => 'read a note',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateNote' => 
  array (
    'type' => 0,
    'description' => 'update a note',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteNote' => 
  array (
    'type' => 0,
    'description' => 'delete a note',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateOwnNote' => 
  array (
    'type' => 1,
    'description' => 'update a note by author himself',
    'bizRule' => 'return Yii::app()->user->name==$params["author"];',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateNote',
    ),
  ),
  'deleteOwnNote' => 
  array (
    'type' => 1,
    'description' => 'delete a note by author himself',
    'bizRule' => 'return Yii::app()->user->name==$params["author"];',
    'data' => NULL,
    'children' => 
    array (
      0 => 'deleteNote',
    ),
  ),
  'guest' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readNote',
    ),
  ),
  'author' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'createNote',
      2 => 'updateOwnNote',
      3 => 'deleteOwnNote',
    ),
    'assignments' => 
    array (
      6 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'author',
      2 => 'deleteNote',
      3 => 'updateNote',
    ),
  ),
);
