<!DOCTYPE html>
<html>
<head>
    <title>Public Exam Report - {{ $publicExam->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .results-list { margin: 0; padding-left: 15px; }
        .meta { margin-bottom: 15px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ config('app.name', 'Y GRO SMS') }}</div>
        <div class="subtitle">Public Exam Report: {{ $publicExam->name }}</div>
    </div>

    <div class="meta">
        <strong>Exam Date:</strong> {{ $publicExam->exam_date ? $publicExam->exam_date->format('d M Y') : 'N/A' }}<br>
        <strong>Description:</strong> {{ $publicExam->description ?? '–' }}<br>
        <strong>Total Candidates:</strong> {{ $publicExam->studentPublicExams->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 25%">Student Name</th>
                <th style="width: 15%">Index Number</th>
                <th style="width: 55%">Results</th>
            </tr>
        </thead>
        <tbody>
        @forelse($publicExam->studentPublicExams as $i => $entry)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <b>{{ $entry->student->name }}</b><br>
                    <small>Grade {{ $entry->student->current_grade }} ({{ $entry->student->stream?->name ?? 'General' }})</small>
                </td>
                <td style="font-family: monospace">{{ $entry->index_number }}</td>
                <td>
                    @if($entry->results->isNotEmpty())
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach($entry->results as $res)
                            <span style="display: inline-block; background: #eee; padding: 2px 6px; border-radius: 4px; margin-bottom: 4px; margin-right: 5px;">
                                {{ $res->subject->name }}: <b>{{ $res->grade }}</b>
                            </span>
                        @endforeach
                        </div>
                    @else
                        <span style="color: #999;">Result pending</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align: center; padding: 20px;">No candidates found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i:s') }}
    </div>
</body>
</html>
