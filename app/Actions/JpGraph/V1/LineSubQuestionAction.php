<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\AnswersChartData;
use function Safe\define;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

// JpGraph mark constants - these are global constants defined by JpGraph
// We'll use them directly without namespace imports since they're global

// Fallback constant definitions for PHPStan compatibility
if (! defined('Amenadiel\\JpGraph\\MARK_FILLEDCIRCLE')) {
    define('Amenadiel\\JpGraph\\MARK_FILLEDCIRCLE', 1);
    define('Amenadiel\\JpGraph\\MARK_UTRIANGLE', 2);
    define('Amenadiel\\JpGraph\\MARK_SQUARE', 3);
    define('Amenadiel\\JpGraph\\MARK_DTRIANGLE', 4);
    define('Amenadiel\\JpGraph\\MARK_DIAMOND', 5);
    define('Amenadiel\\JpGraph\\MARK_CIRCLE', 6);
    define('Amenadiel\\JpGraph\\MARK_CROSS', 7);
    define('Amenadiel\\JpGraph\\MARK_STAR', 8);
    define('Amenadiel\\JpGraph\\MARK_X', 9);
    define('Amenadiel\\JpGraph\\MARK_LEFTTRIANGLE', 10);
    define('Amenadiel\\JpGraph\\MARK_RIGHTTRIANGLE', 11);
    define('Amenadiel\\JpGraph\\MARK_FLASH', 12);
}

class LineSubQuestionAction
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $chart = $answersChartData->chart;
        $answers = $answersChartData->answers;
        $graph = app(GetGraphAction::class)->execute($chart);

        $labels = $answers->toCollection()->pluck('label')->all();
        $data = $answers->toCollection()->pluck('value')->all();
        $answers_first = $answers->first();
        Assert::isInstanceOf($answers_first, AnswerData::class);
        $legends = [];
        if (is_array($answers_first->value)) {
            $legends = array_keys($answers_first->value);
        }

        // $legends = collect(collect($data)->first())->keys()->all();

        $graph->SetScale('textlin');

        // $graph->SetMargin(40, 20, 33, 58);

        // $graph->title->Set('Background Image');
        $graph->SetBox(false);

        // PHPStan Level 10: isset() invece di property_exists() per oggetti JpGraph
        if (isset($graph->yaxis) && is_object($graph->yaxis)) {
            if (method_exists($graph->yaxis, 'HideZeroLabel')) {
                $graph->yaxis->HideZeroLabel();
            }
            if (method_exists($graph->yaxis, 'HideLine')) {
                $graph->yaxis->HideLine(false);
            }
            if (method_exists($graph->yaxis, 'HideTicks')) {
                $graph->yaxis->HideTicks(false, false);
            }
        }

        if (isset($graph->xaxis) && is_object($graph->xaxis)) {
            if (method_exists($graph->xaxis, 'SetTickLabels')) {
                $graph->xaxis->SetTickLabels($labels);
            }
            if (method_exists($graph->xaxis, 'SetLabelAngle')) {
                $graph->xaxis->SetLabelAngle($chart->x_label_angle);
            }
        }

        if (isset($graph->ygrid) && is_object($graph->ygrid) && method_exists($graph->ygrid, 'SetFill')) {
            $graph->ygrid->SetFill(false);
        }
        // $graph->SetBackgroundImage('tiger_bkg.png', BGIMG_FILLFRAME);
        $p = [];
        $colors = [
            '#55bbdd',
            '#aaaaaa',
            '#d60021',
            '#0baa90',
        ];
        $marks = [
            MARK_FILLEDCIRCLE, // A filled circle

            MARK_UTRIANGLE, // A triangle pointed upwards
            MARK_SQUARE, // A filled square
            MARK_DTRIANGLE, // A triangle pointed downwards
            MARK_DIAMOND, // A diamond
            MARK_CIRCLE, // A circle

            MARK_CROSS, // A cross
            MARK_STAR, // A star
            MARK_X, // An 'X'
            MARK_LEFTTRIANGLE, // A half triangle, vertical line to left (used as group markers for Gantt charts)
            MARK_RIGHTTRIANGLE, // A half triangle, vertical line to right (used as group markers for Gantt charts)
            MARK_FLASH, // A Zig-Zag vertical flash
        ];

        foreach ($legends as $i => $legend) {
            $tmp_data = array_column($data, $legend);
            $p[$i] = new LinePlot($tmp_data);
            $graph->Add($p[$i]);
            $p[$i]->SetColor($colors[$i]);

            $p[$i]->SetLegend($legend);
            // PHPStan Level 10: isset() per oggetti JpGraph
            if (isset($p[$i]->mark) && is_object($p[$i]->mark)) {
                if (method_exists($p[$i]->mark, 'SetType')) {
                    $p[$i]->mark->SetType($marks[$i], '', 1.2);
                }
                if (method_exists($p[$i]->mark, 'SetColor')) {
                    $p[$i]->mark->SetColor($colors[$i]);
                }
            }
            // dddx($this->vars['transparency']);
            // $p[$i]->mark->SetFillColor($colors[$i].'@'.$this->vars['transparency']); // trasparenza da 0 a 1
            // $p[$i]->mark->SetFillColor($colors[$i]);
            $p[$i]->SetCenter();
        }

        // PHPStan Level 10: isset() per oggetti JpGraph
        if (isset($graph->legend) && is_object($graph->legend)) {
            if (method_exists($graph->legend, 'SetFrameWeight')) {
                $graph->legend->SetFrameWeight(1);
            }
            if (method_exists($graph->legend, 'SetColor')) {
                $graph->legend->SetColor('#4E4E4E', '#00A78A');
            }
            if (method_exists($graph->legend, 'SetMarkAbsSize')) {
                $graph->legend->SetMarkAbsSize(8);
            }
        }

        $title = $chart->title;
        if (isset($graph->title) && $graph->title instanceof Text) {
            $graph->title->Set($title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }

        $subtitle = $chart->subtitle;
        if (isset($graph->subtitle) && $graph->subtitle instanceof Text) {
            $graph->subtitle->Set($subtitle);
            $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);
        }

        if (isset($graph->footer) && is_object($graph->footer)) {
            if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
                $graph->footer->center->Set('');
            }
        }

        return $graph;
    }
}
