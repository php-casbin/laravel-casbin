<?php
namespace CasbinAdapter\Laravel;

use CasbinAdapter\Laravel\Models\CasbinRule;
use Casbin\Exceptions\CasbinException;
use Casbin\Persist\Adapter as AdapterContract;
use Casbin\Persist\AdapterHelper;

/**
 * DatabaseAdapter
 * @author techlee@qq.com
 */
class Adapter implements AdapterContract
{
    use AdapterHelper;

    protected $casbinRule;

    public function __construct(CasbinRule $casbinRule)
    {
        $this->casbinRule = $casbinRule;
    }

    public function savePolicyLine($ptype, array $rule)
    {

        $col['ptype'] = $ptype;
        foreach ($rule as $key => $value) {
            $col['v' . strval($key)] = $value;
        }

        $this->casbinRule->create($col);
    }

    public function loadPolicy($model)
    {
        $rows = $this->casbinRule->get()->toArray();

        foreach ($rows as $row) {
            $line = implode(', ', array_slice(array_values($row), 1));
            $this->loadPolicyLine(trim($line), $model);
        }
    }

    public function savePolicy($model)
    {
        foreach ($model->model['p'] as $ptype => $ast) {
            foreach ($ast->policy as $rule) {
                $this->savePolicyLine($ptype, $rule);
            }
        }

        foreach ($model->model['g'] as $ptype => $ast) {
            foreach ($ast->policy as $rule) {
                $this->savePolicyLine($ptype, $rule);
            }
        }
        return true;
    }

    public function addPolicy($sec, $ptype, $rule)
    {
        return $this->savePolicyLine($ptype, $rule);
    }

    public function removePolicy($sec, $ptype, $rule)
    {
        $result = $this->casbinRule->where('ptype', $ptype);

        foreach ($rule as $key => $value) {
            $result->where('v' . strval($key), $value);
        }
        return $result->delete();
    }

    public function removeFilteredPolicy($sec, $ptype, $fieldIndex, ...$fieldValues)
    {
        throw new CasbinException("not implemented");
    }
}
