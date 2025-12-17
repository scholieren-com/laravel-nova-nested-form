<?php

namespace Handleglobal\NestedForm;

use Laravel\Nova\Panel;

class NestedFormPanel extends Panel
{
    /**
     * Nested form.
     */
    protected NestedForm $nestedForm;

    /**
     * Constructor.
     */
    public function __construct(NestedForm $nestedForm)
    {
        $this->nestedForm = $nestedForm;

        $this->nestedForm->asPanel($this);

        parent::__construct(__('Update Related :resource', ['resource' => $this->nestedForm->name]), [$this->nestedForm]);
    }

    /**
     * Getter.
     */
    public function __get($offset): mixed
    {
        return property_exists($this, $offset) ? parent::__get($offset) : $this->nestedForm->$offset;
    }

    /**
     * Setter.
     */
    public function __set($key, $value): void
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        } else {
            $this->nestedForm->$key = $value;
        }
    }

    /**
     * Caller.
     */
    public function __call($method, $parameters): mixed
    {
        return method_exists($this, $method) ? parent::__call($method, $parameters) : call_user_func([$this->nestedForm, $method], ...$parameters);
    }
}
