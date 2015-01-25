<?php

  $app->get('/', function() {
    HelloWorldController::index();
  });

  $app->get('/hiekkalaatikko', function() {
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
