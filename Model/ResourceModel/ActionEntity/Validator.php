<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\Gdpr\Model\ResourceModel\ActionEntity;

use Magento\Framework\Validator\AbstractValidator;
use Magento\Framework\Validator\ValidatorInterface;
use function array_merge_recursive;

final class Validator extends AbstractValidator
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    public function __construct(
        array $validators
    ) {
        $this->validators = $validators;
    }

    public function isValid($value): bool
    {
        $isValid = true;
        $messages = [];

        foreach ($this->validators as $validator) {
            $isValid = $isValid && $validator->isValid($value);
            $messages[] = $validator->getMessages();
        }
        $this->_addMessages(array_merge_recursive(...$messages));

        return $isValid && !$this->hasMessages();
    }
}
