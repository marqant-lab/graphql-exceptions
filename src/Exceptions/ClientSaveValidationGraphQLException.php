<?php

namespace Tjventurini\GraphQLExceptions\Exceptions;

use Exception;
use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;
use Illuminate\Validation\ValidationException;

/**
 * Class ClientSaveValidationGraphQLException
 *
 * @package Tjventurini\GraphQLExceptions\Exceptions
 */
class ClientSaveValidationGraphQLException extends Exception implements ClientAware, ProvidesExtensions
{
    /**
    * @var @string
    */
    protected $reason;

    /**
     * Constructor of this exception.
     *
     * @param ValidationException $Exception
     */
    public function __construct(ValidationException $Exception)
    {
        $code = (int) $Exception->getCode();
        // pass general error message, code and previous exception to Exception constructor.
        parent::__construct(trans('graphql-exceptions::errors.validation'), $code, $Exception);

        // save the real error message as reason
        $this->reason = $Exception->getMessage();

        // save the errors to pass them on to the frontend
        $this->errors = $Exception->errors();
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
        return 'validation';
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
            'errors' => $this->errors
        ];
    }
}
