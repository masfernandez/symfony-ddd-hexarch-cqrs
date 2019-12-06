<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\TwigExtension;

use App\Domain\Model\Artist\Artist;
use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OrderExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('orderArtistByAddingDate', array($this, 'oderFilter')),
        );
    }

    /**
     * @param PersistentCollection $array
     * @return mixed
     */
    public function oderFilter($array)
    {
        /** @var \ArrayIterator $iterator */
        $iterator = $array->getIterator();

        $iterator->uasort(function ($first, $second) {
            /** @var Artist $first */
            /** @var Artist $second */
            $date1 = $first->getAddingDate()->getTimestamp();
            $date2 = $second->getAddingDate()->getTimestamp();
            return $date1 > $date2 ? 1 : -1;
        });

        $arrayResult = $iterator->getArrayCopy();
        return $arrayResult;
    }
}