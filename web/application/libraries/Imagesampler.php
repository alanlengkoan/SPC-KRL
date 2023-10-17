<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ImageSampler
{
    private $ci;
    private $img;
    private $callback    = NULL;
    private $initialized = FALSE;

    protected $percent = 5;
    protected $steps   = 10;

    public $w, $h;
    public $sample_w = 0;
    public $sample_h = 0;

    public function __construct()
    {
        $this->ci = &get_instance();
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

    public function set_percent($percent)
    {
        $percent = intval($percent);
        if (($percent < 1) || ($percent > 50)) {
            die("Your \$percent value needs to be between 1 and 50.");
        }
        $this->percent = $percent;
    }

    public function set_steps($steps)
    {
        $steps = intval($steps);
        if (($steps < 1) || ($steps > 50)) {
            die("Your \$steps value needs to be between 1 and 50.");
        }
        $this->steps = $steps;
    }

    private function set_callback($callback)
    {
        try {
            $fn = new \ReflectionFunction($callback);
            if ($fn->getNumberOfParameters() != 4) {
                throw new \ReflectionException("Invalid parameter count in callback function.  Usage: fn(int, int, int, bool) { ... }");
            }
            $this->callback = $callback;
        } catch (\ReflectionException $e) {
            die($e->getMessage());
        }
    }

    public function init()
    {
        $this->sample_w = $this->w / $this->steps;
        $this->sample_h = $this->h / $this->steps;
        $this->initialized = TRUE;
    }

    private function get_pixel_color($x, $y)
    {
        $rgb = imagecolorat($this->img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        return [$r, $g, $b];
    }

    public function sample($callback = NULL)
    {
        if (!$this->initialized) {
            $this->init();
        }
        if (($this->sample_w < 2) || ($this->sample_h < 2)) {
            die("Your sampling size is too small for this image - reduce the \$steps value.");
        }

        if ($callback) {
            $this->set_callback($callback);
        }

        $sample_size = round($this->sample_w * $this->sample_h * $this->percent / 100);

        $retval = [];
        for ($i = 0, $y = 0; $i < $this->steps; $i++, $y += $this->sample_h) {
            $flag = FALSE;
            $row_retval = [];
            for ($j = 0, $x = 0; $j < $this->steps; $j++, $x += $this->sample_w) {
                $total_r = $total_g = $total_b = 0;
                for ($k = 0; $k < $sample_size; $k++) {
                    $pixel_x = $x + rand(0, $this->sample_w - 1);
                    $pixel_y = $y + rand(0, $this->sample_h - 1);
                    list($r, $g, $b) = $this->get_pixel_color($pixel_x, $pixel_y);
                    $total_r += $r;
                    $total_g += $g;
                    $total_b += $b;
                }
                $avg_r = round($total_r / $sample_size);
                $avg_g = round($total_g / $sample_size);
                $avg_b = round($total_b / $sample_size);
                if ($this->callback) {
                    call_user_func_array($this->callback, [$avg_r, $avg_g, $avg_b, !$flag]);
                }
                $row_retval[] = [$avg_r, $avg_g, $avg_b];
                $flag = TRUE;
            }
            $retval[] = $row_retval;
        }

        return $retval;
    }

    // RGB Values:Number 0-255
    // HSV Results:Number 0-1
    public function rgb_to_hsv($R, $G, $B)
    {
        $HSL = array();

        $var_R = ($R / 255);
        $var_G = ($G / 255);
        $var_B = ($B / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $V = $var_Max;

        if ($del_Max == 0) {
            $H = 0;
            $S = 0;
        } else {
            $S = $del_Max / $var_Max;

            $del_R = ((($var_Max - $var_R) / 6) + ($del_Max / 2)) / $del_Max;
            $del_G = ((($var_Max - $var_G) / 6) + ($del_Max / 2)) / $del_Max;
            $del_B = ((($var_Max - $var_B) / 6) + ($del_Max / 2)) / $del_Max;

            if ($var_R == $var_Max) $H = $del_B - $del_G;
            else if ($var_G == $var_Max) $H = (1 / 3) + $del_R - $del_B;
            else if ($var_B == $var_Max) $H = (2 / 3) + $del_G - $del_R;

            if ($H < 0) $H++;
            if ($H > 1) $H--;
        }

        $HSL['H'] = $H;
        $HSL['S'] = $S;
        $HSL['V'] = $V;

        return $HSL;
    }
}
