<?php
namespace app\components;

use Imagine\Image\BoxInterface;
use Imagine\Image\Point as OriginalPoint;
use Imagine\Image\PointInterface;

class StartPoint implements PointInterface
{
    /**
     * @var BoxInterface
     */
    private $box;

    /**
     * Constructs coordinate with size instance, it needs to be relative to
     *
     * @param BoxInterface $box
     */
    public function __construct(BoxInterface $box)
    {
        $this->box = $box;
    }

    /**
     * {@inheritdoc}
     */
    public function getX()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getY()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function in(BoxInterface $box)
    {
        return $this->getX() < $box->getWidth() && $this->getY() < $box->getHeight();
    }

    /**
     * {@inheritdoc}
     */
    public function move($amount)
    {
        return new OriginalPoint($this->getX() + $amount, $this->getY() + $amount);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('(%d, %d)', $this->getX(), $this->getY());
    }
}