<?php

namespace Uteq\Move\Fields;

class Step extends Panel
{
    public string $component = 'form.step';

    public string $next;

    public string $attribute;

    public bool $hideTitle = true;

    public bool $isActive = false;

    public bool $disabled = true;

    public bool $showNextOnEdit = false;
    public ?string $nextText = null;

    public bool $hideCancel = false;

    public ?string $cancelRoute = null;

    public function __construct(string $name, string $attribute, array $fields)
    {
        $this->attribute = $attribute;

        parent::__construct($name, $fields);
    }

    public function disabled(): bool
    {
        return ! $this->active()
            && ! $this->isComplete()
            && ! $this->isAvailable();
    }

    public function active(): bool
    {
        if (! isset($this->resourceForm)) {
            return false;
        }

        return $this->attribute === $this->resourceForm->activeStep();
    }

    public function isComplete(): bool
    {
        return in_array(
            $this->attribute,
            $this->resourceForm->completedSteps
        );
    }

    public function isAvailable(): bool
    {
        return in_array($this->attribute, $this->resourceForm->availableSteps);
    }

    public function showTitle($show = true): static
    {
        $this->hideTitle = ! $show;

        return $this;
    }

    public function next(string $next, ?string $text = null, $showOnEdit = false): static
    {
        $this->next = $next;
        $this->showNextOnEdit = $showOnEdit;
        $this->nextText = $text;

        return $this;
    }

    public function cancelRoute($cancelRoute): static
    {
        $this->cancelRoute = $cancelRoute;

        return $this;
    }

    public function hideCancel($hideCancel = true): static
    {
        $this->hideCancel = $hideCancel;

        return $this;
    }
}
