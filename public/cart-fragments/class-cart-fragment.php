<?php
namespace CartPops\Cart\Fragments;

if ( ! defined( 'WPINC' ) ) {
	die; }

/**
 * Base class to render a cart fragment.
 *
 * @since 1.4.3
 */
abstract class Fragment {
	/**
	 * Fragment settings.
	 *
	 * @var CartPops\Cart\Fragments\Fragment_Settings
	 */
	protected $settings = null;

	/**
	 * Constructor.
	 *
	 * @param Cart_Fragment_Settings $settings
	 */
	public function __construct( Cart_Fragment_Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Indicates if the fragment should be rendered.
	 *
	 * @return boolean
	 */
	protected function should_render(): bool {
		return true;
	}

	/**
	 * Performs the actual rendering of the fragment. This method should simply
	 * produce an output, without returning any value. The public method Fragment::render()
	 * will take care of buffering and returing that output.
	 *
	 * @return void
	 */
	abstract protected function render_fragment(): void;

	/**
	 * Renders the fragment, returning the output generated by the rendering.
	 *
	 * @return string
	 */
	public function render(): string {
		if ( ! $this->should_render() ) {
			return '';
		}

		ob_start();

		// Render the fragment
		$this->render_fragment();

		return ob_get_clean();
	}

	/**
	 * Instantiates the fragment, using the specified settings, and returns the HTML
	 * generated by the rendering of the fragment.
	 *
	 * @param Cart_Fragment_Settings $settings
	 * @return string
	 */
	public static function get_html( Cart_Fragment_Settings $settings ): string {
		$fragment = new static( $settings );
		return $fragment->render();
	}
}
