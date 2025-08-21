<?php
namespace ahmed14ayman\phpmvc\form;

use ahmed14ayman\phpmvc\Model;

abstract class BaseField{

    public Model $model;
    public string $attribute;

      public function __construct(Model $model,string $attribute) {
      
        $this->model = $model;
        $this->attribute = $attribute;

    }


    public abstract function renderInput():string;
    
    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label >%s</label>
                %s
                <div class="invalid-feedback">
                %s
                </div>
            </div>
    ',
        $this->model->getLabel($this->attribute),
        $this->renderInput(),
        $this->model->getFirstError($this->attribute)
    );
    }
}