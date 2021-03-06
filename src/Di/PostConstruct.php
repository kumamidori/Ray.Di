<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Di package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\Di\Di;

/**
 * PostConstruct
 *
 * The PostConstruct annotation is used on a method that needs to be executed after dependency injection is done to
 * perform any initialization. This method MUST be invoked before the class is put into service. The method annotated
 * with PostConstruct MUST be invoked even if the class does not request any resources to be injected. Only one method
 * can be annotated with this annotation. The method on which the PostConstruct annotation is applied MUST fulfill
 * all of the following criteria
 *
 *  - The method MUST NOT have any parameters.
 *  - The return type of the method MUST be void.
 *
 * @Annotation
 * @Target("METHOD")
 */
final class PostConstruct
{
}
