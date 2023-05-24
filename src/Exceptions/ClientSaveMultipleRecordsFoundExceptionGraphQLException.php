<?php

namespace Tjventurini\GraphQLExceptions\Exceptions;

use Exception;
use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ClientSaveMultipleRecordsFoundExceptionGraphQLException
 *
 * @package Tjventurini\GraphQLExceptions\Exceptions
 */
class ClientSaveMultipleRecordsFoundExceptionGraphQLException extends Exception implements ClientAware, ProvidesExtensions
{
    /**
    * @var @string
    */
    protected $reason;

    /**
     * Constructor of this exception.
     *
     * @param  MultipleRecordsFoundException $Exception
     * @return void
     * @throws BindingResolutionException
     */
    public function __construct(MultipleRecordsFoundException $Exception)
    {
        // pass general error message, code and previous exception to Exception constructor.
        parent::__construct(trans('graphql-exceptions::errors.multiple_records_found'), $Exception->getCode(), $Exception);

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
        return 'multiple_records_found';
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
