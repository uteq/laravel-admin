<?php

namespace Uteq\Move\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Uteq\Move\Facades\Move;

trait HasResource
{
    use HasMountActions;

    public $resource;
    public $model = null;
    public $modelId = null;

    public function initializeHasResource()
    {
        $this->initializeHasMountActions();

        $this->beforeMount(function () {
            $this->fields = collect($this->getFieldsProperty());
        });

//        $this->resolveResourceModel();
    }

    public function resolveResourceModel()
    {
        $this->model = $this->modelId
            ? $this->resolveModel($this->modelId)
            : $this->resolvedResourceModel();

        return $this->model;
    }

    public function resolvedResourceModel()
    {
        if ($this->model !== null) {
            return $this->model;
        }

        $resource = Move::resolveResource(request()->route()->parameter('resource') ?? $this->resource);

        if (!$resource) {
            return null;
        }

        $model = $resource->model();

        if ($model) {
            $this->modelId = $model->{$model->getKey()};
        }

        return $resource->model();
    }

    public function mountHasResource()
    {
        if ($this->modelId) {
            $this->resource()->resource = $this->model;
        }
    }

    public function resource()
    {
        return $this->resolvedResource;
    }

    public function getResolvedResourceProperty()
    {
        return Move::resolveResource($this->resource);
    }

    public function getResourceProperty()
    {
        return $this->resource();
    }

    public function resolveModel($id)
    {
        return $this->resource()->newModel()->newQuery()->find($id);
    }

    public function resolveFields(Model $model = null, $keepPlaceholder = false, array $fields = null)
    {
        $type = ! $model ? 'create' : ($model->id ? 'update' : 'create');

        return $this->resource()->resolveFields($model, $type, $keepPlaceholder, $fields);
    }

    public function resolveAndMapFields(Model $model, array $store, array $fields = null)
    {
        $model->fill($store);

        $fields ??= $this->resolveFields($model, true);

        return $this->mapFields($fields, $store);
    }

    public function mapFields(array $resolvedFields, $store)
    {
        return collect($resolvedFields)
            ->filter(fn ($field) => isset($store[$field->attribute]))
            ->mapWithKeys(fn ($field) => [$field->attribute => $store[$field->attribute]])
            ->toArray();
    }

    public function resolveFieldRules($model)
    {
        return $this->fields
            ->filter(fn ($field) => $field->isVisible($model, 'update'))
            ->flatMap(fn ($field) => $field->getRules(request()))
            ->toArray();
    }

    public function resolveFieldCreateRules($model)
    {
        return $this->fields
            ->filter(fn ($field) => $field->isVisible($model, 'create'))
            ->flatMap(fn ($field) => $field->getCreationRules(request()))
            ->toArray();
    }

    public function resolveFieldUpdateRules($model)
    {
        return $this->fields
            ->filter(fn ($field) => $field->isVisible($model, 'update'))
            ->flatMap(fn ($field) => $field->getUpdateRules(request()))
            ->toArray();
    }

    public function resolveAndMapFieldToFields($key): array
    {
        $fields = $this->fields()
            ->filter(fn ($field) => $field->attribute === $key)
            ->toArray();

        $store = Arr::dot($this->store);

        return $this->mapFields($this->resolveFields(null, null, $fields), $store);
    }

    public function getFieldRule($key): array
    {
        return collect($this->rules($this->{$this->property}))
            ->filter(fn ($rules, $field) => $field === $key)
            ->toArray();
    }

    public function handleResourceAction($type, $fields)
    {
        $this->resource()->handleAction(
            $type,
            $this->{$this->property},
            $fields,
            'livewire',
        );

        $this->{$this->property}->refresh();

        $this->emit('saved', $this->{$this->property});
    }

    public function getFieldsProperty()
    {
        return collect(
            $this->model
                ? $this->resolveFields($this->model)
                : $this->resource()->resolveFields($this->resource()->model())
        );
    }

    public function fields()
    {
        return $this->fields;
    }

    public function filters()
    {
        return $this->resource()->filters();
    }

    public function actions()
    {
        return $this->resource()->actions();
    }

    public function query(): Builder
    {
        return $this->resource()->{'getFor' . ucfirst(static::$viewType)}($this->requestQuery)['collection'];
    }

    public function collection()
    {
        return $this->cachedCollection;
    }

    public function getCachedCollectionProperty()
    {
        return $this->query()
            ->paginate($this->filter('limit', $this->resource()->defaultPerPage()));
    }
}
