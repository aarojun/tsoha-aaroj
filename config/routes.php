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

  $app->get('/tuotteet', function() {
    HelloWorldController::tuotteet();
  });
