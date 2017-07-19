<?php
class Url {
	private $url;
	private $ssl;

	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}

	public function applink($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
			$url = $this->ssl . 'preface.sw?app=' . $route;
		} else {
			$url = $this->url . 'preface.sw?app=' . $route;
		}
		
		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}

		return $url; 
	}

    public function getlink($route, $args = '', $secure = false) {
        if ($this->ssl && $secure) {
            $url = $this->ssl . 'preface.sw?get=' . $route;
        } else {
            $url = $this->url . 'preface.sw?get=' . $route;
        }

        if ($args) {
            if (is_array($args)) {
                $url .= '&amp;' . http_build_query($args);
            } else {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
            }
        }

        return $url;
    }

    public function uilink($route, $args = '', $secure = false) {
        if ($this->ssl && $secure) {
            $url = $this->ssl . 'preface.sw?ui=' . $route;
        } else {
            $url = $this->url . 'preface.sw?ui=' . $route;
        }

        if ($args) {
            if (is_array($args)) {
                $url .= '&amp;' . http_build_query($args);
            } else {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
            }
        }

        return $url;
    }
}