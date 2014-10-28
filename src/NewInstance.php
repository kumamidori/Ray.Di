<?php
/**
 * This file is part of the Ray package.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\Di;

use Ray\Aop\Bind as AopBind;

final class NewInstance
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var SetterMethods
     */
    private $setterMethods;

    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @var AopBind
     */
    private $bind;

    /**
     * @param \ReflectionClass $class
     * @param SetterMethods    $setterMethods
     * @param Name             $constructorName
     */
    public function __construct(
        \ReflectionClass $class,
        SetterMethods $setterMethods,
        Name $constructorName = null
    ) {
        $constructorName = $constructorName ?: new Name(Name::ANY);
        $this->class = $class->name;
        $constructor = $class->getConstructor();
        if ($constructor) {
            $this->parameters = new Parameters($constructor, $constructorName);
        }
        $this->setterMethods = $setterMethods;
    }

    /**
     * @param string  $class
     * @param AopBind $bind
     */
    public function weaveAspects($class, AopBind $bind)
    {
        $this->class = $class;
        $this->bind = new AspectBind($bind);
    }

    /**
     * @param Container $container
     *
     * @return object
     */
    public function __invoke(Container $container)
    {
        // constructor injection
        $instance = $this->parameters ? (new \ReflectionClass($this->class))->newInstanceArgs($this->parameters->get($container)) : new $this->class;

        // setter injection
        $this->setterMethods->__invoke($instance, $container);

        // is provider ?
        if ($instance instanceof ProviderInterface) {
            $instance = $instance->get();
        }

        // bind dependency injected interceptors
        if ($this->bind instanceof AspectBind) {
            $instance->bind = $this->bind->inject($container);
        }
        return $instance;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->class;
    }
}
