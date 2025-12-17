<?php

namespace Handleglobal\NestedForm;

class NestedFormChild extends NestedFormSchema
{

    /**
     * Name of the fields' fitler method.
     *
     * @var string
     */
    protected static string $filterMethod = 'updateFields';

    /**
     * Get the current heading.
     */
    protected function heading(): string
    {
        $heading = isset($this->parentForm->heading) ? $this->parentForm->heading : $this->parentForm::wrapIndex() . '. ' . $this->parentForm->singularLabel;

        return str_replace($this->parentForm::wrapIndex(), $this->index + 1, $heading);
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'resourceId' => $this->model->getKey(),
            $this->parentForm->keyName => $this->model->getKey(),
        ]);
    }
}
