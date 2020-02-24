<?php


class AppleHtml
{
    const HTML_SVG = "<svg viewBox=\"0 0 600 600\" height=\"225\" width=\"225\">
      <!-- top leaf -->
      <path fill=\"green\" d=\"m108,35
            c5.587379,-6.7633 9.348007,-16.178439 8.322067,-25.546439
            c-8.053787,10.32369 -17.792625,5.36682 -23.569427,12.126399
            c-5.177124,5.985922 -9.711121,15.566772 -8.48777,24.749359
            c8.976891,0.69453 18.147476,-4.561718 23.73513,-11.329308\" />
       %s   
       %s
      </svg>";

    const HTML_LEFT_HALF_100 = "
      <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -16.072174,6.151901 -26.213551,6.550446
            c-10.52422,0.398254 -18.538303,-10.539917 -25.26247,-20.251053
            c-13.740021,-19.864456 -24.24024,-56.132286 -10.1411,-80.613663
            c7.004152,-12.157551 19.521101,-19.85622 33.10713,-20.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const HTML_LEFT_HALF_90 ="
        <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -16.072174,6.151901 -26.213551,6.550446
            c-10.52422,0.398254 -18.538303,-10.539917 -25.26247,-20.251053
            c-13.740021,-19.864456 4.24024,-56.132286 -10.1411,-80.613663
            c7.004152,-12.157551 19.521101,-19.85622 33.10713,-20.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const HTML_LEFT_HALF_70 ="
        <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -16.072174,6.151901 -26.213551,6.550446
            c-10.52422,0.398254 -18.538303,-10.539917 -25.26247,-20.251053
            c-13.740021,-19.864456 24.24024,-56.132286 -10.1411,-80.613663
            c7.004152,-12.157551 19.521101,-19.85622 33.10713,-20.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const HTML_LEFT_HALF_50 ="
        <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -16.072174,6.151901 -26.213551,6.550446
            c-10.52422,0.398254 -18.538303,-10.539917 -25.26247,-20.251053
            c-3.740021,-19.864456 54.24024,-46.132286 4.1411,-80.613663
            c-7.004152,-12.157551 19.521101,-19.85622 25.10713,-20.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const HTML_LEFT_HALF_30 ="
        <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -16.072174,6.151901 -26.213551,6.550446
            c-10.52422,0.398254 -18.538303,-10.539917 -17.26247,-20.251053
            c17.004152,12.157551 39.521101,-59.85622 15.10713,-100.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const HTML_LEFT_HALF_10 ="
        <path fill=\"#%s\" %s d=\"%s
            c-12.24469,0 -11.072174,6.151901 -20.213551,0.550446
            c0.52422,0.398254 -7.538303,-6.539917 -3.26247,-1.251053
            c0.004152,-12.157551 39.521101,-49.85622 11.10713,-110.053638
            c10.334515,-0.197132 20.089069,6.952717 26.406689,6.952717\" />";

    const TRANSFORM_RIGHT_PART = "transform=\"translate(200), scale(-1, 1)\"";
    const RIGHT_M = "M117,162.415214";
    const LEFT_M = "M88,162.415214";



    public function getAppleSvg ($color, $eaten){
       if ($eaten <= 0){
           $left = sprintf(self::HTML_LEFT_HALF_100, $color, "", self::LEFT_M);
           $right = sprintf(self::HTML_LEFT_HALF_100, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }
       else if ($eaten <= 20){
           $left = sprintf(self::HTML_LEFT_HALF_90, $color, "", self::LEFT_M);
           if ($eaten <= 10)
               $right = sprintf(self::HTML_LEFT_HALF_100, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
           else
               $right = sprintf(self::HTML_LEFT_HALF_90, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }
       else if ($eaten <= 40){
           $left = sprintf(self::HTML_LEFT_HALF_70, $color, "", self::LEFT_M);
           if ($eaten <= 30)
               $right = sprintf(self::HTML_LEFT_HALF_90, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
           else
               $right = sprintf(self::HTML_LEFT_HALF_70, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }
       else if ($eaten <= 60){
           $left = sprintf(self::HTML_LEFT_HALF_50, $color, "", self::LEFT_M);
           if ($eaten <= 50)
               $right = sprintf(self::HTML_LEFT_HALF_70, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
           else
               $right = sprintf(self::HTML_LEFT_HALF_50, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }
       else if ($eaten <= 80){
           $left = sprintf(self::HTML_LEFT_HALF_30, $color, "", self::LEFT_M);
           if ($eaten <= 70)
               $right = sprintf(self::HTML_LEFT_HALF_50, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
           else
               $right = sprintf(self::HTML_LEFT_HALF_30, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }
       else{
           $left = sprintf(self::HTML_LEFT_HALF_10, $color, "", self::LEFT_M);
           if ($eaten <= 90)
               $right = sprintf(self::HTML_LEFT_HALF_30, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
           else
               $right = sprintf(self::HTML_LEFT_HALF_10, $color, self::TRANSFORM_RIGHT_PART, self::RIGHT_M);
       }

       return sprintf(self::HTML_SVG, $left, $right);
    }
}



