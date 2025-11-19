# Grafici e PDF - Guida Completa Laraxot

## 📋 Indice Generale

### 🎯 Quick Navigation

| Hai bisogno di... | Vai a... |
|-------------------|----------|
| **Creare grafici per PDF** | [JPGraph Step-by-Step](#jpgraph-step-by-step) |
| **Incorporare grafici in PDF** | [Spipu PDF Embedding](#spipu-pdf-embedding) |
| **Grafici interattivi web** | [Chart.js Export](#chartjs-export) |
| **Capire l'architettura** | [Architettura Sistema](#architettura-sistema) |

---

## 📚 Documentazione Tecnica Completa

### 1. JPGraph Step-by-Step

**File:** [jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)

**Contenuto:**
- ✅ Installazione e configurazione JPGraph
- ✅ Creazione grafici base (Bar, Pie, Line, Radar)
- ✅ Export PNG con alta qualità
- ✅ Export SVG (limitazioni e alternative)
- ✅ Personalizzazione completa (colori, font, assi, griglia)
- ✅ Esempi pratici per survey reports
- ✅ Best practices performance e qualità

**Quando usare:**
- Generazione PDF server-side
- Grafici statici di alta qualità
- Batch processing (report multipli)
- No dipendenze JavaScript

**Esempio Quick Start:**

```php
use Modules\Chart\Actions\JpGraph\V1\Bar2Action;
use Modules\Chart\Datas\AnswersChartData;

// Genera grafico
$graph = app(Bar2Action::class)->execute($answersChartData);

// Export PNG
$imageData = $graph->Stroke(_IMG_HANDLER);
ob_start();
imagepng($imageData, null, 6);
$base64 = base64_encode(ob_get_clean());
imagedestroy($imageData);
```

---

### 2. Spipu PDF Embedding

**File:** [../../Quaeris/docs/spipu-pdf-charts-embedding-guide.md](../../Quaeris/docs/spipu-pdf-charts-embedding-guide.md)

**Contenuto:**
- ✅ Come funziona Spipu HTML2PDF
- ✅ Metodi di embedding (Base64, File Path, URL)
- ✅ Flusso JPGraph → PDF passo-passo
- ✅ Flusso Chart.js → PDF passo-passo
- ✅ Layout e posizionamento (page break, multi-column)
- ✅ Ottimizzazione qualità (dimensioni, compressione)
- ✅ Template Blade completo per survey reports
- ✅ Troubleshooting problemi comuni

**Quando usare:**
- Incorporare grafici JPGraph in PDF
- Creare report PDF professionali
- Gestire layout multi-pagina
- Ottimizzare dimensione file PDF

**Esempio Quick Start:**

```php
use Modules\Xot\Actions\Pdf\Engine\SpipuPdfByHtmlAction;

// Prepara dati
$charts = [
    [
        'title' => 'Grafico 1',
        'base64' => $base64FromJpGraph,
    ],
];

// Genera HTML
$html = view('pdf.report', ['charts' => $charts])->render();

// Converti in PDF
$pdfPath = app(SpipuPdfByHtmlAction::class)->execute(
    html: $html,
    filename: 'report.pdf',
    out: 'path',
);
```

---

### 3. Chart.js Export

**File:** [chart-js-export-guide.md](./chart-js-export-guide.md)

**Contenuto:**
- ✅ Setup Chart.js v4.4.3
- ✅ Export client-side (PNG, JPEG, Blob)
- ✅ Export server-side (Puppeteer/Browsershot)
- ✅ Integration con Laravel/Livewire
- ✅ Export SVG (con limitazioni)
- ✅ Service JavaScript completo
- ✅ Backend handler per salvataggio
- ✅ Best practices performance e qualità

**Quando usare:**
- Dashboard interattive
- Grafici real-time
- Export dinamico user-driven
- Web UI con export capabilities

**Esempio Quick Start:**

```javascript
// Client-side
const chart = new Chart(ctx, config);
const base64 = chart.toBase64Image('image/png', 1.0);

// Download
chart.canvas.toBlob((blob) => {
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'chart.png';
    link.click();
});
```

---

## 🏗️ Architettura Sistema

### Stack Completo

```
┌─────────────────────────────────────────────────────────┐
│                   LARAXOT CHART SYSTEM                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌────────────────┐         ┌──────────────────┐       │
│  │  Survey Data   │────────▶│   ChartData +    │       │
│  │  (Questions,   │         │  AnswersChartData│       │
│  │   Responses)   │         └──────────────────┘       │
│  └────────────────┘                  │                  │
│                                      │                  │
│                                      ▼                  │
│         ┌────────────────────────────────────┐          │
│         │    RENDERING ENGINE SELECTION      │          │
│         └────────────────────────────────────┘          │
│                    │                │                   │
│           ┌────────┴────────┐      │                   │
│           ▼                 ▼      ▼                   │
│     ┌──────────┐      ┌──────────┐ ┌──────────┐       │
│     │ JPGraph  │      │Chart.js  │ │ Others   │       │
│     │(Server)  │      │(Client)  │ │(Future)  │       │
│     └──────────┘      └──────────┘ └──────────┘       │
│           │                 │           │              │
│           │                 │           │              │
│           ▼                 ▼           ▼              │
│     ┌──────────┐      ┌──────────┐ ┌──────────┐       │
│     │   PNG    │      │  Canvas  │ │   SVG    │       │
│     │  Base64  │      │  Base64  │ │  (WIP)   │       │
│     └──────────┘      └──────────┘ └──────────┘       │
│           │                 │           │              │
│           └────────┬────────┴───────────┘              │
│                    │                                   │
│                    ▼                                   │
│         ┌──────────────────────┐                       │
│         │   Spipu HTML2PDF     │                       │
│         │  (HTML → PDF Engine) │                       │
│         └──────────────────────┘                       │
│                    │                                   │
│                    ▼                                   │
│         ┌──────────────────────┐                       │
│         │    PDF Document      │                       │
│         │   (Report Output)    │                       │
│         └──────────────────────┘                       │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### Flusso Dati Dettagliato

#### 1. Raccolta Dati Survey

```php
// Survey → Questions → Responses
$survey = SurveyPdf::find($id);
$questions = $survey->questions()->with('responses')->get();
```

#### 2. Preparazione ChartData

```php
// Transform in ChartData + AnswersChartData
$chartData = ChartData::from([
    'type' => 'bar',
    'width' => 700,
    'height' => 400,
    'title' => $question->text,
    // ... configurazione
]);

$answersData = AnswersChartData::from([
    'chart' => $chartData,
    'answers' => $processedResponses,
]);
```

#### 3. Generazione Grafico (JPGraph)

```php
// JPGraph Action
$graph = app(Bar2Action::class)->execute($answersData);

// Export PNG
$imageData = $graph->Stroke(_IMG_HANDLER);
$base64 = base64_encode($pngData);
```

#### 4. Embedding in HTML

```blade
<img src="data:image/png;base64,{{ $base64 }}"
     alt="Grafico"
     style="max-width: 100%; height: auto;" />
```

#### 5. Conversione PDF

```php
// Spipu HTML2PDF
$html2pdf = new Html2Pdf('P', 'A4', 'it');
$html2pdf->writeHTML($html);
$html2pdf->output($path, 'F');
```

---

## 🎯 Use Cases Pratici

### Use Case 1: Report Survey PDF

**Scenario:** Generare report PDF con analisi visiva di un survey

**Stack:**
- JPGraph (grafici server-side)
- Spipu HTML2PDF (conversione PDF)

**Steps:**

1. **Raccogli dati**
   ```php
   $questions = $survey->questions()->with('responses')->get();
   ```

2. **Genera grafici**
   ```php
   foreach ($questions as $question) {
       $graph = $this->generateChart($question);
       $charts[] = $this->toBase64($graph);
   }
   ```

3. **Crea HTML**
   ```php
   $html = view('pdf.report', compact('charts'))->render();
   ```

4. **Converti PDF**
   ```php
   $pdf = app(SpipuPdfByHtmlAction::class)->execute($html);
   ```

**Guide:**
- [jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)
- [spipu-pdf-charts-embedding-guide.md](../../Quaeris/docs/spipu-pdf-charts-embedding-guide.md)

---

### Use Case 2: Dashboard Interattiva

**Scenario:** Dashboard real-time con export PDF

**Stack:**
- Chart.js (grafici client-side)
- Livewire (reattività)
- Laravel API (backend)

**Steps:**

1. **Crea chart interattivo**
   ```javascript
   const chart = new Chart(ctx, config);
   ```

2. **Auto-refresh**
   ```javascript
   setInterval(async () => {
       const data = await fetchLatestData();
       chart.data = data;
       chart.update();
   }, 30000);
   ```

3. **Export on-demand**
   ```javascript
   const base64 = chart.toBase64Image();
   await sendToBackend(base64);
   ```

4. **Backend genera PDF**
   ```php
   $charts = $request->input('charts');
   $pdf = $this->generatePdf($charts);
   ```

**Guide:**
- [chart-js-export-guide.md](./chart-js-export-guide.md)

---

### Use Case 3: Batch Report Generation

**Scenario:** Generare 1000+ report PDF di notte (queue)

**Stack:**
- JPGraph (performance server-side)
- Laravel Queue
- Redis Cache

**Steps:**

1. **Queue job**
   ```php
   dispatch(new GenerateReportsJob($surveyIds));
   ```

2. **Batch processing**
   ```php
   $surveys->chunk(100)->each(function ($chunk) {
       $this->generateBatch($chunk);
   });
   ```

3. **Caching**
   ```php
   $cacheKey = "chart-{$id}";
   $base64 = Cache::remember($cacheKey, 3600, fn() => $this->generate());
   ```

4. **Cleanup**
   ```php
   gc_collect_cycles();
   ```

**Guide:**
- [jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md) (Best Practices)

---

## 📊 Comparison Matrix

### JPGraph vs Chart.js

| Caratteristica | JPGraph | Chart.js | Vincitore |
|----------------|---------|----------|-----------|
| **Server-Side** | ✅ Nativo | ❌ (Puppeteer needed) | JPGraph |
| **Client-Side** | ❌ | ✅ Nativo | Chart.js |
| **Qualità PDF** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | JPGraph |
| **Interattività** | ❌ | ✅ | Chart.js |
| **Performance Batch** | ⭐⭐⭐⭐⭐ | ⭐⭐ | JPGraph |
| **SVG Support** | ⭐⭐ | ⭐⭐⭐ | Chart.js |
| **PNG Quality** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | JPGraph |
| **Facilità Setup** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Chart.js |
| **Memory Usage** | ⭐⭐⭐⭐ | ⭐⭐⭐ | JPGraph |

### Scegliere l'Engine Giusto

```
Hai bisogno di...
│
├─ PDF statici professionali?
│  └─ ✅ JPGraph
│
├─ Dashboard interattive?
│  └─ ✅ Chart.js
│
├─ Real-time updates?
│  └─ ✅ Chart.js
│
├─ Batch generation (100+ PDF)?
│  └─ ✅ JPGraph
│
└─ Export user-driven?
   └─ ✅ Chart.js
```

---

## 🛠️ Tools e Utilities

### Helper Functions

```php
// Chart Generation Helper
function generateChartBase64($question): string
{
    $chartData = ChartData::from([...]);
    $answersData = AnswersChartData::from([...]);

    $graph = app(Bar2Action::class)->execute($answersData);

    $imageData = $graph->Stroke(_IMG_HANDLER);
    ob_start();
    imagepng($imageData, null, 6);
    $base64 = base64_encode(ob_get_clean());
    imagedestroy($imageData);

    return $base64;
}

// PDF Generation Helper
function generatePdfFromCharts(array $charts, string $filename): string
{
    $html = view('pdf.report', compact('charts'))->render();

    return app(SpipuPdfByHtmlAction::class)->execute(
        html: $html,
        filename: $filename,
        out: 'path',
    );
}
```

### Service Classes

```php
// ChartService.php
class ChartService
{
    public function generateForPdf($question): array
    {
        $graph = $this->createGraph($question);
        $base64 = $this->toBase64($graph);

        return [
            'title' => $question->text,
            'base64' => $base64,
            'insights' => $this->generateInsights($question),
        ];
    }

    public function generateMultiple(Collection $questions): array
    {
        return $questions->map(fn($q) => $this->generateForPdf($q))->all();
    }
}
```

---

## 📖 Riferimenti Esterni

### Librerie Ufficiali

- [JPGraph Documentation](https://jpgraph.net/doc/)
- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [Spipu HTML2PDF GitHub](https://github.com/spipu/html2pdf)
- [Spatie Browsershot](https://github.com/spatie/browsershot)

### Documentazione Interna

- [CLAUDE.md](../../../CLAUDE.md) - Regole architettura Laraxot
- [Modulo Xot - PDF Actions](../../Xot/docs/actions/pdf-actions-overview.md)
- [Modulo Quaeris - Survey System](../../Quaeris/README.md)

---

## 🎓 Tutorial Video (Futuro)

- [ ] Tutorial: Creare primo grafico JPGraph
- [ ] Tutorial: Incorporare grafici in PDF
- [ ] Tutorial: Dashboard Chart.js con export
- [ ] Tutorial: Batch PDF generation con Queue

---

## 🤝 Contributing

Per contribuire a questa documentazione:

1. Leggi [CLAUDE.md](../../../CLAUDE.md) per le convenzioni
2. Usa nomenclatura kebab-case per file `.md`
3. Mantieni esempi pratici e funzionanti
4. Testa tutti i codici di esempio
5. Aggiungi screenshots quando possibile

---

## 📝 Changelog Documentazione

### v1.0 (2025-11-17)

- ✅ Guida JPGraph completa con esempi pratici
- ✅ Guida Spipu PDF embedding step-by-step
- ✅ Guida Chart.js export (client e server-side)
- ✅ Use cases dettagliati per ogni scenario
- ✅ Comparison matrix e decision tree
- ✅ Helper functions e service classes

---

<div align="center">

**📊 Sistema Grafici e PDF Laraxot**

*Documentazione completa per generazione grafici e PDF professionali*

**Creato con ❤️ da AI Assistant - Ultimo aggiornamento: 2025-11-17**

</div>
