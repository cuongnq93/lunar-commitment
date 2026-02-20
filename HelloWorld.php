<?php

class HelloWorld
{
    private string $templateDir;

    public function __construct(array $request)
    {
        $this->templateDir = __DIR__ . '/templates';

        $template = $this->resolveTemplate($request['t'] ?? null);

        echo file_get_contents($template);
    }

    /**
     * Resolve the template file path.
     *
     * Priority:
     *  1. Explicit template from query param (?t=2025)
     *  2. Current year template
     *  3. Nearest previous year template (handles Gregorian/Lunar year gap)
     *  4. Default template
     */
    private function resolveTemplate(?string $requested): string
    {
        // Explicit template requested
        if ($requested !== null) {
            $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $requested);
            $path = "{$this->templateDir}/{$sanitized}.html";
            if (file_exists($path)) {
                return $path;
            }
        }

        // Auto-detect: try current year, then find nearest previous year
        $currentYear = (int) date('Y');
        $yearTemplate = $this->findNearestYearTemplate($currentYear);

        if ($yearTemplate !== null) {
            return $yearTemplate;
        }

        return "{$this->templateDir}/default.html";
    }

    /**
     * Find the template for the given year, or the nearest previous year.
     */
    private function findNearestYearTemplate(int $fromYear): ?string
    {
        $availableYears = $this->getAvailableYears();

        if (empty($availableYears)) {
            return null;
        }

        // Exact match
        if (in_array($fromYear, $availableYears, true)) {
            return "{$this->templateDir}/{$fromYear}.html";
        }

        // Find nearest previous year
        $candidates = array_filter($availableYears, fn(int $y) => $y <= $fromYear);

        if (empty($candidates)) {
            return null;
        }

        $nearest = max($candidates);
        return "{$this->templateDir}/{$nearest}.html";
    }

    /**
     * Scan the templates directory for year-based templates.
     */
    private function getAvailableYears(): array
    {
        $files = glob("{$this->templateDir}/[0-9][0-9][0-9][0-9].html");

        return array_map(function (string $file) {
            return (int) basename($file, '.html');
        }, $files);
    }
}
