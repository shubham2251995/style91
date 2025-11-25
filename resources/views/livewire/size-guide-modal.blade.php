<div>
    @if($sizeGuide)
        <!-- Size Guide Button -->
        <button wire:click="openModal" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Size Guide
        </button>

        <!-- Modal -->
        @if($isOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $sizeGuide->name }}</h3>
                                @if($sizeGuide->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $sizeGuide->description }}</p>
                                @endif
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Size Chart -->
                        <div class="mb-6">
                            <h4 class="font-bold mb-3">Size Chart ({{ strtoupper($sizeGuide->measurement_unit) }})</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left border">Size</th>
                                            @foreach(array_keys(reset($sizeGuide->measurements) ?: []) as $measurement)
                                                <th class="px-4 py-2 text-center border capitalize">{{ $measurement }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sizeGuide->measurements as $size => $measurements)
                                            <tr class="hover:bg-gray-50 {{ $recommendedSize === $size ? 'bg-green-50 font-bold' : '' }}">
                                                <td class="px-4 py-2 border font-medium">
                                                    {{ $size }}
                                                    @if($recommendedSize === $size)
                                                        <span class="ml-2 text-green-600 text-xs">✓ Recommended</span>
                                                    @endif
                                                </td>
                                                @foreach($measurements as $value)
                                                    <td class="px-4 py-2 border text-center">{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fit Finder -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold mb-3">Find Your Size</h4>
                            <p class="text-sm text-gray-600 mb-3">Enter your measurements to get a size recommendation</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                @foreach(array_keys(reset($sizeGuide->measurements) ?: []) as $measurement)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1 capitalize">{{ $measurement }} ({{ $sizeGuide->measurement_unit }})</label>
                                        <input type="number" step="0.1" wire:model="userMeasurements.{{ $measurement }}" class="w-full border-gray-300 rounded text-sm" placeholder="--">
                                    </div>
                                @endforeach
                            </div>
                            
                            <button wire:click="findMySize" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Find My Size
                            </button>

                            @if($recommendedSize)
                                <div class="mt-3 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                                    <strong>Recommended Size: {{ $recommendedSize }}</strong>
                                </div>
                            @elseif($recommendedSize === null && count($userMeasurements) > 0)
                                <div class="mt-3 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded text-sm">
                                    No exact match found. Please refer to the size chart above or contact customer support.
                                </div>
                            @endif
                        </div>

                        <!-- How to Measure -->
                        <div class="mt-6 text-sm text-gray-600">
                            <h5 class="font-bold mb-2">How to Measure</h5>
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Chest:</strong> Measure around the fullest part of your chest</li>
                                <li><strong>Waist:</strong> Measure around your natural waistline</li>
                                <li><strong>Hips:</strong> Measure around the fullest part of your hips</li>
                                <li><strong>Length:</strong> Measure from shoulder to hem</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
