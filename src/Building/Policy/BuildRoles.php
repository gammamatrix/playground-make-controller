<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Policy;

/**
 * \Playground\Make\Controller\Building\Policy\BuildRoles
 */
trait BuildRoles
{
    /**
     * @param array<string, string> $searches
     */
    protected function make_roles_to_view(array &$searches): string
    {
        $indent = '    ';

        $content = '';

        $rolesToView = $this->c->rolesToView();
        if (! empty($rolesToView)) {
            foreach ($rolesToView as $i => $role) {
                $content .= sprintf('%2$s\'%3$s\',%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $role,
                    // (count($rolesToView) - 2) >= $i ? ',' : ''
                );
                // $content = trim($content, ',');
            }
        }

        if (! empty($content)) {
            $searches['rolesToView'] = sprintf(
                '%1$s%3$s%2$s',
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['rolesToView'] = '';
        }

        return $searches['rolesToView'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_roles_for_action(array &$searches): string
    {
        $indent = '    ';

        $content = '';

        $rolesForAction = $this->c->rolesForAction();
        if (! empty($rolesForAction)) {
            foreach ($rolesForAction as $i => $role) {
                $content .= sprintf('%2$s\'%3$s\',%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $role,
                    // (count($rolesForAction) - 2) >= $i ? ',' : ''
                );
                // $content = trim($content, ',');
            }
        }

        if (! empty($content)) {
            $searches['rolesForAction'] = sprintf(
                '%1$s%3$s%2$s',
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['rolesForAction'] = '';
        }

        return $searches['rolesForAction'];
    }
}
