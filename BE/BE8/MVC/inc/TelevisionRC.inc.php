
<?php
/*
 * This is a CONTROLLER
 */
      require_once './inc/TelevisionI.inc.php';
      require_once './inc/Television.inc.php';   // the model
      require_once './inc/TelevisionV1.inc.php'; // a view

      class TelevisionRC {
          private $model;

          public function __construct() {
              $this->model = new Television();    // model create
          }

          public function action($p) {
              if (isset($p['on'])) {
                  $this->model->tvOnOff();
              } elseif (isset($p['chup'])) {
                  $this->model->chUp();
              } elseif (isset($p['chdown'])) {
                  $this->model->chDown();
              } elseif (isset($p['volup'])) {
                  $this->model->volUp();
              } elseif (isset($p['voldown'])) {
                  $this->model->volDown();
              } elseif (isset($p['mute'])) {
                  $this->model->mute();
              }
              $v = new TelevisionV1($this->model);    // create view
              $v->display();                          // use the view
          }
      }
