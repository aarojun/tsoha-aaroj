<?php

  $app->get('/', function() {
    ProductController::index();
  });

  $app->post('/product', function(){
    ProductController::store();
  });

  $app->post('/product_type', function(){
    ProductTypeController::store();
  });

  $app->post('/product/:id/edit', function($id){
    ProductController::update($id);
  });

  $app->post('/product_type/:id/edit', function($id){
    ProductTypeController::update($id);
  });

  $app->post('/product/:id/destroy', function($id){
    ProductController::destroy($id);
  });

  $app->post('/product_type/:id/destroy', function($id){
    ProductTypeController::destroy($id);
  });

  $app->post('/user', function() {
    UserController::handle_login();
  });

  $app->post('/logout', function() {
    UserController::logout();
  });

  $app->get('/product/:id/edit', function($id){
    ProductController::edit($id);
  });

  $app->get('/product_type/:id/edit', function($id){
    ProductTypeController::edit($id);
  });

  $app->get('/product/new', function(){
    ProductController::create();
  });

  $app->get('/product_type/new', function(){
    ProductTypeController::create();
  });

  $app->get('/product_type', function(){
    ProductTypeController::index();
  });

  $app->get('/product&type=:type', function($type) {
    ProductController::indexByType($type);
  });

  $app->get('/product', function() {
    ProductController::index();
  });

  $app->get('/product/:id', function($id) {
    ProductController::show($id);
  });

  $app->get('/hiekkalaatikko', function() {
    //koodin testaamiseen
    HelloWorldController::sandbox();
  });

  $app->get('/login', function() {
    UserController::login();
  });

  $app->get('/tuotelista', function() {
    HelloWorldController::tuotelista();
  });

  $app->get('/ostoskassi', function() {
    OrderController::ostoskassi();
  });

  $app->get('/product_show', function() {
    HelloWorldController::product_show();
  });

  $app->get('/product_modify', function() {
    HelloWorldController::product_modify();
  });

  $app->get('/product_add', function() {
    HelloWorldController::product_add();
  });
