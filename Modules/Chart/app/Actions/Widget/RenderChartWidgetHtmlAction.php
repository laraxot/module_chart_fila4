<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Widget;

use Filament\Widgets\ChartWidget;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * Action per renderizzare un Filament ChartWidget come HTML standalone
 *
 * Genera HTML completo con Chart.js embedded, pronto per essere
 * renderizzato da Browsershot o visualizzato in browser.
 */
class RenderChartWidgetHtmlAction
{
    use QueueableAction;

    private const CHARTJS_VERSION = '4.4.3';
    private const DATALABELS_VERSION = '2.2.0';

    /**
     * @param ChartWidget $widget
     * @param int $width
     * @param int $height
     * @return string
     */
    public function execute(
        ChartWidget $widget,
        int $width = 1200,
        int $height = 600
    ): string {
        Assert::greaterThan($width, 0, 'Width must be positive');
        Assert::greaterThan($height, 0, 'Height must be positive');

        $data = $this->getWidgetData($widget);
        $type = $this->getWidgetType($widget);
        $options = $this->getWidgetOptions($widget);
        $heading = $this->getWidgetHeading($widget);

        $chartConfig = [
            'type' => $type,
            'data' => $data,
            'options' => $options,
        ];

        $chartConfigJson = json_encode($chartConfig, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return $this->createHtml($chartConfigJson, $width, $height, $heading);
    }

    /**
     * @param string $chartConfig
     * @param int $width
     * @param int $height
     * @param string|null $heading
     * @return string
     */
    private function createHtml(
        string $chartConfig,
        int $width,
        int $height,
        ?string $heading = null
    ): string {
        $title = $heading ?? 'Chart Widget';
        $chartJsVersion = self::CHARTJS_VERSION;
        $datalabelsVersion = self::DATALABELS_VERSION;

        return <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@{$chartJsVersion}/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@{$datalabelsVersion}"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: white;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 20px;
        }
        .chart-container { width: {$width}px; height: {$height}px; position: relative; }
        .chart-heading {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="chart-heading">{$title}</div>
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chart').getContext('2d');
            const config = {$chartConfig};
            const chart = new Chart(ctx, config);
            console.log('✅ Chart.js renderizzato con successo');
        });
    </script>
</body>
</html>
HTML;
    }

    /**
     * @param ChartWidget $widget
     * @return array<string, mixed>
     */
    private function getWidgetData(ChartWidget $widget): array
    {
        try {
            $reflection = new \ReflectionClass($widget);
            $method = $reflection->getMethod('getData');
            $method->setAccessible(true);
            $data = $method->invoke($widget);
            Assert::isArray($data);

            /** @var array<string, mixed> $data */
            return $data;
        } catch (\ReflectionException $e) {
            throw new \RuntimeException("Failed to get widget data: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * @param ChartWidget $widget
     * @return string
     */
    private function getWidgetType(ChartWidget $widget): string
    {
        try {
            $reflection = new \ReflectionClass($widget);
            $method = $reflection->getMethod('getType');
            $method->setAccessible(true);
            $type = $method->invoke($widget);
            Assert::string($type);

            return $type;
        } catch (\ReflectionException $e) {
            return 'line';
        }
    }

    /**
     * @param ChartWidget $widget
     * @return array<string, mixed>
     */
    private function getWidgetOptions(ChartWidget $widget): array
    {
        try {
            $reflection = new \ReflectionClass($widget);
            $method = $reflection->getMethod('getOptions');
            $method->setAccessible(true);
            $options = $method->invoke($widget);
            Assert::isArray($options);

            /** @var array<string, mixed> $options */
            return $options;
        } catch (\ReflectionException $e) {
            return [];
        }
    }

    /**
     * @param ChartWidget $widget
     * @return string|null
     */
    private function getWidgetHeading(ChartWidget $widget): ?string
    {
        try {
            $reflection = new \ReflectionClass($widget);
            $property = $reflection->getProperty('heading');
            $property->setAccessible(true);
            $heading = $property->getValue($widget);
            Assert::nullOrString($heading);

            return $heading;
        } catch (\ReflectionException $e) {
            return null;
        }
    }
}
