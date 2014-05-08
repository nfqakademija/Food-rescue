<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FrameWorkersTMFoodRescueFoodAppBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
