<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Policy;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Policy\BuildRevisions
 */
trait BuildRevisions
{
    protected function make_revision_handling(): void
    {
        $model = $this->c->model();
        $model_revision = $model.'Revision';
        $model_column = Str::of($model)->snake()->replace('-', '_')->toString();

        $model_fqdn = $this->model?->fqdn();

        if ($model_fqdn) {
            $this->c->addToUse($model_fqdn);
            $this->c->addToUse($model_fqdn.'Revision');
        }

        // use Illuminate\Auth\Access\Response;
        // use Illuminate\Contracts\Auth\Authenticatable;
        $this->c->addToUse('Illuminate\Auth\Access\Response');
        $this->c->addToUse('Illuminate\Contracts\Auth\Authenticatable');
        $this->buildClass_uses();

        $this->searches['revisions'] = PHP_EOL.PHP_EOL;

        $this->searches['revisions'] .= <<<PHP_CODE
    /**
     * Determine whether the user can view the revision index.
     */
    public function revisions(Authenticatable \$user): bool|Response
    {
        return \$this->verify(\$user, 'viewAny');
    }

    /**
     * Determine whether the user can view a revision.
     */
    public function viewRevision(Authenticatable \$user, {$model}Revision \${$model_column}_revision): bool|Response
    {
        return \$this->verify(\$user, 'view');
    }

    /**
     * Determine whether the user can restore the $model Revision.
     */
    public function restoreRevision(Authenticatable \$user, {$model}Revision \${$model_column}_revision): bool|Response
    {
        return \$this->verify(\$user, 'restore');
    }
PHP_CODE;

        // $this->searches['revisions'] .= PHP_EOL;
    }
}
