<?php

namespace atk4\ui\FormField;

/**
 *
 */

class MyUpload extends Upload
{

  public function init()
{
    parent::init();
}

  public function onDelete($fx = null)
     {
         if (is_callable($fx)) {
             $this->hasDeleteCb = true;
             if ($this->cb->triggered() && @$_POST['action'] === 'delete') {
                 $fileName = @$_POST['f_name'];
                 $this->cb->set(function () use ($fx, $fileName) {
                     $this->addJsAction(call_user_func_array($fx, [$fileName]));
                     return $this->jsActions;
                 });
             }
         }
     }

     public function onUpload($fx = null)
    {
        if (is_callable($fx)) {
            $this->hasUploadCb = true;
            if ($this->cb->triggered()) {
                $action = @$_POST['action'];
                if ($files = @$_FILES) {
                    //set fileId to file name as default.
                    $this->fileId = $files['file']['name'];
                    $_SESSION['name_file'] = $files['file']['name'];
                    $_SESSION['size_file'] = $files['file']['size'];
                    $_SESSION['tmp_file'] = $files['file']['tmp_name'];
                    $_SESSION['type_file'] = $files['file']['type'];
                    // display file name to user as default.
                    $this->setInput($this->fileId);
                }
                if ($action === 'upload' && !$files['file']['error']) {
                    $this->cb->set(function () use ($fx, $files) {
                        $this->addJsAction(call_user_func_array($fx, $files));
                        //$value = $this->field ? $this->field->get() : $this->content;
                        $this->addJsAction([
                            $this->js()->atkFileUpload('updateField', [$this->fileId, $this->getInputValue()]),
                        ]);
                        return $this->jsActions;
                    });
                } elseif ($action === null || isset($files['file']['error'])) {
                    $this->cb->set(function () use ($fx, $files) {
                        return call_user_func($fx, 'error');
                    });
                }
            }
        }
    }
}
