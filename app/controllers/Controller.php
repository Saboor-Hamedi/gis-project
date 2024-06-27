<?php

declare(strict_types=1);

namespace blog\controllers;

class Controller
{
  const VIEWS_PATH = __DIR__ . '/../../public/views/';
  const HELPERS_PATH = __DIR__ . '/../../functions/';
  protected $viewData = [];

  /**
   * Render a view file.
   *
   * @param string $view The path to the view file relative to the views directory.
   * @param array $data Data to be extracted and available to the view.
   *
   * @throws \Exception If the view file does not exist.
   */
  public function views(string $view, array $data = []): void
  {
    // Build the full path to the view file
    $viewPath = self::VIEWS_PATH . str_replace('/', DIRECTORY_SEPARATOR, $view) . '.php';

    // Ensure the view file exists
    if (!file_exists($viewPath)) {
      throw new \Exception("View <strong>{$view}.php</strong> does not exist");
    }

    // Securely extract data
    $safeData = $this->sanitizeData($data);
    // Merge default view data
    $this->addDefaultViewData();
    $safeData = array_merge($this->viewData, $safeData);

    // Use output buffering to capture the view output
    ob_start();
    extract($safeData, EXTR_SKIP);
    $this->addDefaultViewData();
    require $viewPath;
    $output = ob_get_clean();

    // Output the captured content
    echo $output;
  }

  protected function addDefaultViewData(): void
  {
    $this->viewData['errors'] = $this->viewData['errors'] ?? [];
  }

  /**
   * Sanitize data to be extracted into the view.
   *
   * @param array $data The data to sanitize.
   * @return array The sanitized data.
   */
  protected function sanitizeData(array $data): array
  {
    // Implement any data sanitization logic here, if needed.
    return $data;
  }

  /**
   * Include a helper file.
   *
   * @param string $helper The name of the helper file to include.
   *
   * @throws \Exception If the helper file does not exist.
   */
  public function includeHelper(string $helper): void
  {
    $helperPath = self::HELPERS_PATH . str_replace('/', DIRECTORY_SEPARATOR, $helper) . '.php';

    if (!file_exists($helperPath)) {
      throw new \Exception("Helper <strong>{$helper}.php</strong> does not exist");
    }

    require_once $helperPath;
  }
  public function redirect(string $url, int $statusCode = 302): void
  {
    header('Location: ' . $url, true, $statusCode);
    exit();
  }
}
