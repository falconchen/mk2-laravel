<div class="">
    

    <form class="px-4 py-8 mx-auto mt-8 space-y-8 bg-white rounded md:w-1/2" wire:submit.prevent="submit"
        x-data="{ uploading: false, progress: 0 ,fail: false}"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-error="uploading = false; fail = true"
        x-on:livewire-upload-progress="progress = $event.detail.progress"

    >

        <h1 class="text-2xl font-bold text-center">Upload Your Ebook</h1>

        @if (session()->has('message'))
        <div class="p-4 text-blue-700 bg-blue-100 border-l-4 border-blue-500" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('message') }}</p>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="p-4 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div>
            <label for="kindle_email" class="block text-sm font-medium leading-5 text-gray-700">
                Your Sent To Kindle Email Address


            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="kindle_email"
                id="kindle_email"
                type="email"
                required autofocus class="block px-3 py-2 w-full placeholder-gray-400 rounded-md border border-gray-300 transition duration-150 ease-in-out appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 sm:text-sm sm:leading-5" placeholder="example@kindle.com" />
            </div>

        </div>






        <div class="p-4 space-y-2 bg-gray-50 rounded-md border-2 border-gray-300 border-dashed">

            <div class="w-full h-24 flex items-center justify-center cursor-pointer {{ isset($ebook) ? 'border-none' : 'border-2 border-dashed' }}"
                @if ( $ebook ) wire:click="resetEbook" @endif
                @click.native="$refs.fileInput.click();progress=0"
            >



                <input type="file" hidden wire:model="ebook" x-ref="fileInput" accept=".epub,.pdf,.txt" />
                <div class="flex flex-col text-center">

                    @if (isset($ebook))

                        <strong>
                            {{ $ebook->getClientOriginalName() }}
                         </strong>
                        {{-- // Available file properties.
                        $fileOriginalName = $this->file->getClientOriginalName();
                        $fileTemporaryPath = $this->file->getRealPath();
                        $fileSize = $this->file->getSize();
                        $fileMimeType = $this->file->getMimeType();
                        $fileExtension = $this->file->getClientOriginalExtension(); --}}
                        <p>{{ formatSizeUnits( $ebook->getSize()) }}</p>
                    @else
                        <div x-show="!uploading">
                        Click here to select a file
                        <div x-show="fail">upload failed</div>
                        </div>
                        <div x-show="uploading" style="display:none">
                            <div x-text="`${progress}%`"></div>
                            <progress max="100"  x-bind:value="progress" x-show.transition.opacity="uploading"></progress>
                        </div>


                    @endif


                </div>
            </div>
        </div>


        <button
        class="px-3 py-2 w-full text-center text-white bg-blue-600 rounded-md hover:bg-blue-700"
        x-bind:disabled="uploading" x-bind:class="{' pointer-events-none opacity-50 cursor-not-allowed': uploading }"
        type="submit">

            Submit
        </button>

    </form>
</div>


