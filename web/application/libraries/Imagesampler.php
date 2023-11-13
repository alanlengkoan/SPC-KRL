<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ImageSampler
{
    private $img;

    public $w, $h;

    public function __construct()
    {
    }

    public function image($imagefile)
    {
        if (!$this->img = $this->read_image_extension($imagefile)) {
            die("Error loading image: {$imagefile}");
        }
        $this->w = imagesx($this->img);
        $this->h = imagesy($this->img);
    }

    private function read_image_extension($image)
    {
        $check_extension = pathinfo($image, PATHINFO_EXTENSION);
        if ($check_extension == 'jpg' || $check_extension == 'jpeg') {
            $image = imagecreatefromjpeg($image);
        } elseif ($check_extension == 'png') {
            $image = imagecreatefrompng($image);
        } else {
            $image = imagecreatefromjpeg($image);
        }
        return $image;
    }

    public function calculateGLCM($distance = 1, $angle = 0)
    {
        // Initialize GLCM matrix
        $glcm = array();

        // Calculate GLCM
        for ($x = 0; $x < $this->w; $x++) {
            for ($y = 0; $y < $this->h; $y++) {
                $value = imagecolorat($this->img, $x, $y);
                $pixel = imagecolorsforindex($this->img, $value);

                // Convert to grayscale
                $gray = round(($pixel['red'] + $pixel['green'] + $pixel['blue']) / 3);

                // Get neighbor coordinates
                $neighborX = $x + $distance * cos(deg2rad($angle));
                $neighborY = $y + $distance * sin(deg2rad($angle));

                // Ensure neighbor coordinates are within bounds
                if ($neighborX >= 0 && $neighborX < $this->w && $neighborY >= 0 && $neighborY < $this->h) {
                    // Get neighbor value
                    $neighborValue = imagecolorat($this->img, $neighborX, $neighborY);
                    $neighborPixel = imagecolorsforindex($this->img, $neighborValue);
                    $neighborGray = round(($neighborPixel['red'] + $neighborPixel['green'] + $neighborPixel['blue']) / 3);

                    // Update GLCM matrix
                    $glcm[$gray][$neighborGray] = isset($glcm[$gray][$neighborGray]) ? $glcm[$gray][$neighborGray] + 1 : 1;
                }
            }
        }

        return $glcm;
    }


    public function calculateContrast($glcm)
    {
        $contrast = 0;
        foreach ($glcm as $i => $row) {
            foreach ($row as $j => $value) {
                $contrast += pow($i - $j, 2) * $value;
            }
        }

        return $contrast;
    }

    public function calculateCorrelation($glcm)
    {
        $meanI = 0;
        $meanJ = 0;
        $stdDevI = 0;
        $stdDevJ = 0;

        foreach ($glcm as $i => $row) {
            foreach ($row as $j => $value) {
                $meanI += $i * $value;
                $meanJ += $j * $value;
            }
        }

        foreach ($glcm as $i => $row) {
            foreach ($row as $j => $value) {
                $stdDevI += pow($i - $meanI, 2) * $value;
                $stdDevJ += pow($j - $meanJ, 2) * $value;
            }
        }

        $stdDevI = sqrt($stdDevI);
        $stdDevJ = sqrt($stdDevJ);

        $correlation = 0;
        foreach ($glcm as $i => $row) {
            foreach ($row as $j => $value) {
                $correlation += (($i - $meanI) * ($j - $meanJ) * $value) / ($stdDevI * $stdDevJ);
            }
        }

        return $correlation;
    }

    public function calculateEnergy($glcm)
    {
        $energy = 0;
        foreach ($glcm as $row) {
            foreach ($row as $value) {
                $energy += pow($value, 2);
            }
        }

        return $energy;
    }

    public function calculateHomogeneity($glcm)
    {
        $homogeneity = 0;
        foreach ($glcm as $i => $row) {
            foreach ($row as $j => $value) {
                $homogeneity += $value / (1 + abs($i - $j));
            }
        }

        return $homogeneity;
    }
}
