<?php namespace ConsoleUtils;

/**
 * A library to send data to the console
 *
 * @author Joan Fabrégat <joan@jona.pro
 * @version 1.0
 */
class Console {
	const YES_MODE_ANSWER = 'y';
	
	// Colors
	const COLOR_WHITE = '0';
	const COLOR_GREEN = '32';
	const COLOR_RED = '31';
	const COLOR_PURPLE = '35';
	const COLOR_BLACK = '30';
	const COLOR_BLUE = '34';
	const COLOR_CYAN = '36';
	const COLOR_BROWN = '33';
	const COLOR_LIGHT_GRAY = '30';
	
	/**
	 * Verifies if the quiet mode is enabled.
	 *
	 * @see Console::enableQuietMode()
	 * @see Console::disableQuietMode()
	 * @see Console::isQuietModeEnabled()
	 * @var bool
	 */
	private static $quietMode = false;
	
	/**
	 * Verifies if the yes mode (answers "y" to all questions and do not prompt) is enabled.
	 *
	 * @see Console::enableYesMode()
	 * @see Console::disableYesMode()
	 * @see Console::isYesModeEnabled()
	 * @var bool
	 */
	private static $yesMode = false;
	
	/**
	 * Sends a message to the console
	 *
	 * @param string $message
	 * @param bool|null $newLine
	 */
	public static function send(string $message, bool $newLine = null) {
		if (!self::isQuietModeEnabled()) {
			echo $message;
			if ($newLine) echo "\n";
		}
	}
	
	/**
	 * Sends a green [done] at the end of a processing line.
	 */
	public static function done() {
		self::setColor(self::COLOR_GREEN);
		self::send(" [done]", true);
		self::setColor(self::COLOR_WHITE);
	}
	/**
	 * Sends a red [error] at the end of a processing line.
	 */
	public static function error() {
		self::setColor(self::COLOR_RED);
		self::send(" [error]", true);
		self::setColor(self::COLOR_WHITE);
	}
	
	/**
	 * Changes the text's color.
	 *
	 * @param string $color
	 */
	public static function setColor(string $color) {
		self::send("\e[{$color}m");
	}
	
	/**
	 * Prompts the user for a question.
	 *
	 * @see readline()
	 * @param string $message
	 * @return string
	 */
	public static function prompt(string $message):string {
		if (!self::isYesModeEnabled()) {
			return readline($message);
		}
		return self::YES_MODE_ANSWER;
	}
	
	/**
	 * Reports an axception.
	 *
	 * @param \Exception $exception
	 */
	public static function reportException(\Exception $exception) {
		self::reportError("Error ".get_class($exception).":\n".$exception->getMessage());
	}
	
	/**
	 * Reports an error. The message can be multi-lines.
	 *
	 * @param string $message
	 */
	public static function reportError(string $message) {
		self::setColor(self::COLOR_RED);
		self::send("\n".str_repeat("-", 91)."\n");
		foreach (explode("\n", $message) as $line) {
			self::send("| ".str_pad($line, 88)."|\n");
		}
		self::send(str_repeat("-", 91)."\n\n");
		self::setColor(self::COLOR_WHITE);
	}
	
	/** Enables the quiet mode */
	public static function enableQuietMode() { self::$quietMode = true; }
	
	/** Disables the quiet mode */
	public static function disableQuietMode() { self::$quietMode = true; }
	
	/** Verifies if the quiet mode is enabled @return bool */
	public static function isQuietModeEnabled():bool { return self::$quietMode; }
	
	/** Enables the yes mode */
	public static function enableYesMode() { self::$yesMode = true; }
	
	/** Disables the yes mode */
	public static function disableYesMode() { self::$yesMode = true; }
	
	/** Verifies if the yes mode is enabled @return bool */
	public static function isYesModeEnabled():bool { return self::$yesMode; }
}