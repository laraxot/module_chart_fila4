# Chart Module Documentation

## Overview
The Chart module provides comprehensive data visualization and charting capabilities for the Laraxot system. It integrates with various data sources and provides customizable charts for dashboards, reports, and analytics.

## Key Features
- **Multiple Chart Types**: Support for line, bar, pie, area, and other chart types
- **Data Integration**: Seamless integration with Eloquent models and database queries
- **Customization**: Extensive styling and configuration options
- **Responsive Design**: Mobile-friendly charts that adapt to different screen sizes
- **Export Capabilities**: Export charts to various formats (PNG, PDF, SVG)

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Widgets
- `ChartWidget` - Base chart widget class
- `LineChartWidget` - Line chart implementation
- `BarChartWidget` - Bar chart implementation
- `PieChartWidget` - Pie chart implementation
- `AreaChartWidget` - Area chart implementation

### Resources
- `ChartResource` - Filament resource for chart management
- `ChartTemplateResource` - Resource for chart templates

### Services
- `ChartService` - Core chart generation logic
- `ChartRenderer` - Chart rendering service
- `ChartExporter` - Chart export functionality

## Implementation Guide

### Basic Usage
```php
// Create a simple line chart
class SalesChart extends LineChartWidget
{
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [100, 200, 150, 300, 250],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }
}
```

### Advanced Configuration
```php
// Custom chart with advanced options
class CustomChart extends BarChartWidget
{
    protected static ?string $heading = 'Custom Chart';
    
    protected static ?int $sort = 1;
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getData(): array
    {
        // Complex data processing logic
        return parent::getData();
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
```

## Chart Types
1. **Line Charts**: For trend analysis over time
2. **Bar Charts**: For comparing quantities across categories
3. **Pie Charts**: For showing proportions and distributions
4. **Area Charts**: For cumulative data visualization
5. **Scatter Charts**: For correlation analysis
6. **Radar Charts**: For multi-dimensional data comparison

## Data Sources
- Eloquent models
- Database queries
- API endpoints
- Static data arrays
- Real-time data streams

## Customization Options
- **Colors**: Custom color schemes and gradients
- **Animations**: Entry and hover animations
- **Labels**: Custom axis labels and formatting
- **Tooltips**: Interactive data tooltips
- **Legends**: Custom legend positioning and styling

## Performance Considerations
1. **Data Pagination**: For large datasets
2. **Caching**: Cache frequently accessed chart data
3. **Lazy Loading**: Load charts only when visible
4. **Optimization**: Optimize database queries for chart data

## Related Modules
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [UI Module](../UI/docs/README.md) - User interface components
- [Quaeris Module](../Quaeris/docs/README.md) - Main application module

## Troubleshooting
Common issues and solutions:
- Chart not rendering
- Data formatting issues
- Performance problems with large datasets
- Export functionality errors