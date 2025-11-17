<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Link</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @if($settings['disable_copy_print'] ?? true)
    <style>
        .protected-content {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            .no-print, .no-print * {
                display: none !important;
            }
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 48px;
                color: rgba(0,0,0,0.1);
                z-index: 9999;
            }
        }
        
        .watermark {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
            color: rgba(0,0,0,0.3);
            z-index: 1000;
            pointer-events: none;
        }
    </style>
    @endif
</head>
<body class="bg-gray-50">
    @if($settings['disable_copy_print'] ?? true)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4 no-print">
        <div class="flex">
            <div class="flex-shrink-0">
                ⚠️
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Copying and printing are disabled for this content. Screenshots cannot be prevented.
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 protected-content">
        <h1 class="text-2xl font-semibold mb-6">Shared Links</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Label</th>
                        <th class="px-4 py-2 border">URL</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">Files</th>
                        @if($settings['allow_downloads'] ?? false)
                        <th class="px-4 py-2 border">Download</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($link->label ?? [] as $i => $label)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>

                            <td class="px-4 py-2 border">
                                @if($settings['mask_fields'] ?? true)
                                    {{ \App\Helpers\MaskHelper::maskSensitiveData($label) }}
                                @else
                                    {{ $label ?? 'N/A' }}
                                @endif
                            </td>

                            <td class="px-4 py-2 border">
                                <a href="{{ $link->url[$i] ?? '#' }}" target="_blank" class="text-blue-600 underline">
                                    @if($settings['mask_fields'] ?? true)
                                        {{ \App\Helpers\MaskHelper::maskUrl($link->url[$i] ?? '') }}
                                    @else
                                        {{ $link->url[$i] ?? 'N/A' }}
                                    @endif
                                </a>
                            </td>

                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                    {{ $link->type[$i] ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-4 py-2 border">
                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                    @foreach($link->file[$i] as $file)
                                        <span class="text-sm">
                                            {{ basename($file) }}
                                        </span><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>

                            @if($settings['allow_downloads'] ?? false)
                            <td class="px-4 py-2 border">
                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                    @foreach($link->file[$i] as $file)
                                        <a href="{{ route('shared.file.download', ['token' => $shareToken->token, 'file' => basename($file)]) }}" 
                                           class="text-blue-600 underline text-sm">
                                            Download
                                        </a><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($settings['watermark'] ?? true)
    <div class="watermark no-print">
        Viewed by: {{ request()->ip() }} | {{ now()->format('Y-m-d H:i:s') }}
    </div>
    @endif

    @if($settings['disable_copy_print'] ?? true)
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable copy (Ctrl+C, Cmd+C)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
                e.preventDefault();
                alert('Copying is disabled for this content.');
            }
            
            // Disable print (Ctrl+P, Cmd+P)
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                alert('Printing is disabled for this content.');
            }
        });

        // Additional protection - disable text selection
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
        });
    </script>
    @endif
</body>
</html>