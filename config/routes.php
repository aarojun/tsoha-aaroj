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

  $app->get('/product/new', function(){
    ProductController::create();
  });

  $app->get('/product_type/new', function(){
    ProductTypeController::create();
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
    HelloWorldController::login();
  });

  $app->get('/tuotelista', function() {
    HelloWorldController::tuotelista();
  });

  $app->get('/ostoskassi', function() {
    HelloWorldController::ostoskassi();
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
