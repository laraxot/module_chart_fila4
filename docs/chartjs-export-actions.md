# Chart.js Export Actions Documentation

## Overview

This document describes the actions created to handle Chart.js export to SVG and PNG formats in the Laraxot framework. These actions follow the Laraxot architecture patterns using Spatie QueueableAction.

## Actions Overview

### 1. ExportToPngAction

This action prepares chart data for PNG export. Since Chart.js runs client-side, this action provides the data structure needed for client-side canvas to PNG conversion.

**Location**: `Modules/Chart/app/Actions/ChartJs/ExportToPngAction.php`

> **Aggiornamento 18 novembre 2025**  
> L’azione ora usa `Webmozart\Assert` per validare base64 e contenuti dei file, documenta gli array come `list<string>` e normalizza il risultato di `Storage::get()` per mantenere PHPStan livello 10.

**Usage**:
```php
$result = app(ExportToPngAction::class)->execute(
    $chartData,           // Chart.js configuration data
    $chartId,             // HTML ID of the chart canvas
    $options              // Export options (quality, scale, etc.)
);
```

**Options**:
- `quality`: PNG quality (0.0 to 1.0, default 1.0)
- `scale`: Scale factor for high DPI (default 2)
- `filename`: Output filename (default 'chart_{timestamp}.png')
- `width`: Chart width (default from chart data or 800)
- `height`: Chart height (default from chart data or 600)

### 2. ExportToSvgAction

This action generates SVG content from Chart.js data on the server side. It supports multiple chart types including bar, line, pie, and doughnut charts.

**Location**: `Modules/Chart/app/Actions/ChartJs/ExportToSvgAction.php`

> **18 novembre 2025 – aggiornamento**  
> L'azione è stata completamente tipizzata: normalizza datasets/labels, usa Safe helpers per l'escaping e applica controlli sui valori numerici per evitare errori PHPStan livello 10.

**Usage**:
```php
$result = app(ExportToSvgAction::class)->execute(
    $chartData,           // Chart.js configuration data
    $options               // Export options
);
```

**Options**:
- `width`: SVG width (default from chart data or 800)
- `height`: SVG height (default from chart data or 600)
- `filename`: Output filename (default 'chart_{timestamp}.svg')
- `title`: Chart title (default from chart data or 'Chart')
- `includeStyles`: Whether to include basic CSS styles (default true)

**Supported Chart Types**:
- Bar charts
- Line charts  
- Pie charts
- Doughnut charts
- Generic chart (fallback)

### 3. SaveSvgToFileAction

This action saves the generated SVG content to a file in the storage directory.

**Location**: `Modules/Chart/app/Actions/ChartJs/SaveSvgToFileAction.php`

**Usage**:
```php
$filePath = app(SaveSvgToFileAction::class)->execute(
    $svgContent,          // SVG content string
    $filename,            // Optional filename
    $directory            // Directory relative to storage (default 'charts')
);
```

### 4. SavePngToFileAction

This action saves base64-encoded PNG data (typically from client-side canvas) to a file.

**Location**: `Modules/Chart/app/Actions/ChartJs/SavePngToFileAction.php`

**Usage**:
```php
$filePath = app(SavePngToFileAction::class)->execute(
    $base64Data,          // Base64 encoded PNG data
    $filename,            // Optional filename
    $directory            // Directory relative to storage (default 'charts')
);
```

## Integration with Filament Widgets

To use these actions with Filament chart widgets, you would typically implement the following pattern:

### Example: Chart Widget with Export Functionality

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Chart\Actions\ChartJs\ExportToSvgAction;
use Modules\Chart\Actions\ChartJs\ExportToPngAction;
use Modules\Chart\Actions\ChartJs\SaveSvgToFileAction;
use Modules\Chart\Actions\ChartJs\SavePngToFileAction;

class SampleChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Sample Chart';
    
    protected static ?string $maxHeight = '300px';
    
    protected int | string | array $columnSpan = 'full';
    
    public string $chartId = 'sample-chart';
    
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sample Data',
                    'data' => [10, 20, 30, 40, 25],
                    'backgroundColor' => ['rgba(54, 162, 235, 0.2)'],
                    'borderColor' => ['rgba(54, 162, 235, 1)'],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
    
    public function exportToSvg()
    {
        $chartData = $this->getData();
        $chartData['type'] = $this->getType();
        $chartData['width'] = 800;
        $chartData['height'] = 600;
        
        $result = app(ExportToSvgAction::class)->execute($chartData);
        
        $filePath = app(SaveSvgToFileAction::class)->execute(
            $result['svg_content'],
            'sample_chart_' . time() . '.svg'
        );
        
        return response()->download($filePath);
    }
    
    public function exportToPng()
    {
        // For client-side export, prepare data for JavaScript
        $chartData = $this->getData();
        $chartData['type'] = $this->getType();
        $chartData['width'] = 800;
        $chartData['height'] = 600;
        
        $result = app(ExportToPngAction::class)->execute(
            $chartData,
            $this->chartId
        );
        
        // Return the configuration for client-side processing
        return response()->json($result);
    }
}
```

### Example: Blade Template with Client-Side Export

```blade
<div class="chart-container">
    <canvas id="{{ $chartId }}"></canvas>
    
    <div class="export-buttons">
        <button wire:click="exportToSvg" class="bg-blue-500 text-white px-4 py-2 rounded">
            Export SVG
        </button>
        
        <button onclick="exportChartToPng()" class="bg-green-500 text-white px-4 py-2 rounded">
            Export PNG
        </button>
    </div>
</div>

<script>
function exportChartToPng() {
    @this.exportToPng().then(response => {
        const chart = Chart.getChart('{{ $chartId }}');
        if (chart) {
            // Get PNG data from chart
            const dataUrl = chart.toBase64Image();
            
            // Send to server to save
            fetch('/api/chart/save-png', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    base64Data: dataUrl,
                    filename: 'chart_' + Date.now() + '.png'
                })
            }).then(response => {
                if (response.ok) {
                    // Download the saved file
                    response.blob().then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'chart_' + Date.now() + '.png';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    });
                }
            });
        }
    });
}
</script>
```

## Best Practices

1. **Queue Heavy Operations**: Use the `QueueableAction` trait for operations that might be resource-intensive.

2. **Validate Input**: Always validate chart data and options before processing.

3. **Handle Different Chart Types**: The SVG generation supports multiple chart types, but ensure you're providing the correct data structure.

4. **File Management**: Clean up temporary files and implement appropriate file retention policies.

5. **Client-Server Coordination**: For PNG export, coordinate between client-side canvas generation and server-side file saving.

## Error Handling

All actions include proper error handling:

- Invalid base64 data is detected and throws an exception
- Missing directories are created automatically
- File extensions are validated and corrected if necessary
- Chart data is validated before SVG generation

## Performance Considerations

- SVG generation is done server-side and can be resource-intensive for complex charts
- PNG data is typically generated client-side and sent to server for storage
- Use queuing for batch export operations
- Consider caching for frequently exported charts

These actions provide a complete solution for Chart.js export functionality while following the Laraxot framework conventions and architecture patterns.