<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Configuration;

use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Controller\Configuration\Policy
 */
class Policy extends PrimaryConfiguration
{
    /**
     * @var array<int, string>
     */
    protected array $rolesForAction = [];

    /**
     * @var array<int, string>
     */
    protected array $rolesToView = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'model' => '',
        'model_fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'playground' => false,
        // properties
        'models' => [],
        'rolesForAction' => [],
        'rolesToView' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['rolesForAction'])
            && is_array($options['rolesForAction'])
        ) {
            foreach ($options['rolesForAction'] as $role) {
                if ($role && is_string($role)) {
                    $this->addRoleForAction($role);
                }
            }
        }

        if (! empty($options['rolesToView'])
            && is_array($options['rolesToView'])
        ) {
            foreach ($options['rolesToView'] as $role) {
                if ($role && is_string($role)) {
                    $this->addRoleToView($role);
                }
            }
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function rolesForAction(): array
    {
        return $this->rolesForAction;
    }

    public function addRoleForAction(string $role): self
    {
        if ($role && ! in_array($role, $this->rolesForAction)) {
            $this->rolesForAction[] = $role;
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function rolesToView(): array
    {
        return $this->rolesToView;
    }

    public function addRoleToView(string $role): self
    {
        if ($role && ! in_array($role, $this->rolesToView)) {
            $this->rolesToView[] = $role;
        }

        return $this;
    }
}
