<?php
if ( !class_exists( 'DCF_HTML' ) ) {
	/**
	 * DECAF html helper class
	 *
	 * This class creates js/css output for debugging purposes
	 */
	class DCF_HTML {
		/**
		 * instance object
		 */
		protected static $instance = NULL;

		/**
		 * config var
		 */
		protected $config;




		/**
		 * gets a singleton instance
		 *
		 * @return object
		 */
		public static function getInstance() {
			if ( self::$instance == NULL ) {
				self::$instance = new DCF_HTML();
			}

			return self::$instance;
		}

		/**
		 * sets the path prefix value
		 *
		 * @param string  $_value path prefix
		 * @return boolean
		 */
		public static function setPathPrefix( $_value ) {
			$obj = self::getInstance();

			return $obj->setConfig( 'pathPrefix', $_value );
		}

		/**
		 * sets the livereload value
		 *
		 * @param boolean  $_value
		 * @return boolean
		 */
		public static function setLiveReload( $_value ) {
			$obj = self::getInstance();

			return $obj->setConfig( 'liveReload', $_value );
		}

		/**
		 * sets the css files
		 *
		 * @param mixed   $_value css files
		 * @return boolean
		 */
		public static function setCssFiles( $_value ) {
			$obj = self::getInstance();

			return $obj->setConfig( 'cssFiles', $_value );
		}

		/**
		 * composes head js/css tags
		 *
		 * @return string
		 */
		public static function composeHead() {
			$obj = self::getInstance();

			return $obj->compose( 'head' );
		}

		/**
		 * composes body js/css tags
		 *
		 * @return string
		 */
		public static function composeBody() {
			$obj = self::getInstance();

			return $obj->compose( 'body' );
		}

		/**
		 * checks debug mode
		 *
		 * @param array   $_config configuration values
		 * @return boolean
		 */
		public static function isDebug() {
			$obj = self::getInstance();

			if ( file_exists( $obj->getConfig( 'docRoot' ).'/'.$obj->getConfig( 'debugFile' ) ) ) {
				return TRUE;
			}
			return FALSE;
		}

		/**
		 * inits the configuration
		 *
		 * @param array   $_config configuration values
		 * @return boolean
		 */
		public static function init( $_config = array() ) {
			$obj = self::getInstance();

			$obj->setConfig( $_config );
		}









		/**
		 * constructor
		 */
		public function __construct() {
			// define default values
			$this->config['pathPrefix']       = '';
			$this->config['liveReload']       = FALSE;
			$this->config['docRoot']          = realpath( dirname( __FILE__ ).'/../..' );
			$this->config['debugFile']        = '_DEBUG';
			$this->config['cssFolder']        = 'static/css_src';
			$this->config['cssMinFolder']     = 'static/css';
			$this->config['cssFiles']         = array( 'site.css' );
			$this->config['jsHeadFile']       = 'static/js/head.min.js';
			$this->config['jsHeadJsonFile']   = 'static/js/head.json';
			$this->config['jsBodyFile']       = 'static/js/body.min.js';
			$this->config['jsBodyJsonFile']   = 'static/js/body.json';
			$this->config['jsLiveReloadFile'] = 'static/js/src/vendor/livereload.js?host=localhost';
		}

		/**
		 * gets config values
		 *
		 * @param string  $_key the config parameter name
		 * @return mixed
		 */
		public function getConfig( $_key = NULL ) {
			if ( $_key == NULL ) {
				return $this->config;
			}
			else {
				return $this->config[ $_key ];
			}
		}

		/**
		 * sets a config value
		 *
		 * @return boolean
		 */
		public function setConfig( $_key = NULL, $_value = NULL ) {
			if ( is_array( $_key ) ) {
				$this->config = array_merge( $this->config, $_key );
			}
			else {
				if ( array_key_exists( $_key , $this->config ) ) {
					switch ( $_key ) {
					case 'cssFiles':
						if ( !is_array( $_value ) ) $_value = array( $_value );
						$this->config[$_key] = $_value;
						break;
					default:
						$this->config[$_key] = $_value;
					}
					return TRUE;
				}
			}
			return FALSE;
		}

		/**
		 * general composing function for js/css tags
		 *
		 * @param string  $_type composing type (body [default] or head)
		 * @return string
		 */
		public function compose( $_type = 'body' ) {
			$html = '';

			// debug mode
			if ( $this->isDebug() ) {
				if ( $_type == 'head' ) {
					$html .= PHP_EOL;
					$html .= '<!-- styles debug mode | '.__CLASS__.' -->'.PHP_EOL;
					foreach ( $this->getConfig( 'cssFiles' ) as $k => $v ) {
						$file = $this->_getFile( $this->getConfig( 'cssFolder' ).'/'.$v );
						if ( $file ) $html .= '<link rel="stylesheet" href="'.$file.'" />'.PHP_EOL;
					}
					$html .= '<!-- /styles debug mode | '.__CLASS__.' -->'.PHP_EOL;

					$jsJsonFile = $this->getConfig( 'jsHeadJsonFile' );
				}
				else {
					$jsJsonFile = $this->getConfig( 'jsBodyJsonFile' );
				}

				if ( is_readable( $this->getConfig( 'docRoot' ).'/'.$jsJsonFile ) ) {
					$scriptsContent = file_get_contents( $this->getConfig( 'docRoot' ).'/'.$jsJsonFile );
					$scriptsJson = json_decode( $scriptsContent, TRUE );

					// add livereload.js
					if ( $_type == 'body' && $this->getConfig( 'liveReload' ) ) {
						array_push( $scriptsJson, $this->getConfig( 'jsLiveReloadFile' ) );
					}
					if ( count( $scriptsJson ) > 0 ) {
						$html .= PHP_EOL;
						$html .= '<!-- scripts debug mode | '.__CLASS__.' -->'.PHP_EOL;
						foreach ( $scriptsJson as $v ) {
							$file = $this->_getFile( $v );
							if ($file) $html .= '<script src="'.$file.'"></script>'.PHP_EOL;
						}
						$html .= '<!-- /scripts debug mode | '.__CLASS__.' -->'.PHP_EOL;
					}
				}
			}
			// standard mode
			else {
				if ( $_type == 'head' ) {
					foreach ( $this->getConfig( 'cssFiles' ) as $k => $v ) {
						$file = $this->_getFile( $this->getConfig( 'cssMinFolder' ).'/'.$v );
						if ( $file ) $html .= '<link rel="stylesheet" href="'.$file.'" />'.PHP_EOL;
					}
					$jsFile = $this->getConfig( 'jsHeadFile' );
				}
				else {
					$jsFile = $this->getConfig( 'jsBodyFile' );
				}
				if ( is_readable( $this->getConfig( 'docRoot' ).'/'.$jsFile ) ) {
					$file = $this->_getFile( $jsFile );
					if ($file) $html .= '<script src="'.$file.'"></script>'.PHP_EOL;
				}
			}

			return $html;
		}

		/**
		 * gets the file with modified timestamp
		 *
		 * @param string  $_file the filename
		 * @return string
		 */
		protected function _getFile( $_file ) {
			$sep = '?';
			$file = $_file;

			if ( strpos( $file, '?' )!==FALSE ) {
				$sep = '&amp;';
				$file = parse_url( $file, PHP_URL_PATH );
			}
			if ( is_readable( $this->getConfig( 'docRoot' ).'/'.$file ) ) {
				$file = $this->getConfig( 'pathPrefix' ).$_file.$sep.filemtime( $this->getConfig( 'docRoot' ).'/'.$file );
				return $file;
			}
			return FALSE;
		}
	}
}
