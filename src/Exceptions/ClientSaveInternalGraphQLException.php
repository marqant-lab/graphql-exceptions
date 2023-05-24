<?php

namespace Tjventurini\GraphQLExceptions\Exceptions;

use Exception;
use Throwable;
use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;

/**
 * Class ClientSaveInternalGraphQLException
 *
 * @package Tjventurini\GraphQLExceptions\Exceptions
 */
class ClientSaveInternalGraphQLException extends Exception implements ClientAware, ProvidesExtensions
{
    /**
    * @var @string
    */
    protected $reason;

    /**
     * Constructor of this exception.
     *
     * @param  Throwable $Exception
     * @return void
     */
    public function __construct(Throwable $Exception)
    {
        $code = (int) $Exception->getCode();
        // pass general error message, code and previous exception to Exception constructor.
        parent::__construct(trans('graphql-exceptions::errors.internal'), $code, $Exception);

        // save the real error message as reason
        $this->reason = $Exception->getMessage();
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'internal';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function getExtensions(): array
    {
        return [
            'reason' => $this->reason,
        ];
    }
}
