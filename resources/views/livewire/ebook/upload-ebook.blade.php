<div class="">


    <form class="space-y-8 md:w-1/2 px-4 py-8 bg-white rounded  mt-8 mx-auto" wire:submit.prevent="submit">

        <h1 class="text-center font-bold text-lg">Upload Your Ebook</h1>

        @if (session()->has('message'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('message') }}</p>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div>
            <label for="kindle_email" class="block text-sm font-medium text-gray-700 leading-5">
                Your Sent To Kindle Email Address


            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="kindle_email"
                id="kindle_email"
                type="email"
                required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 " placeholder="example@kindle.com" />
            </div>

        </div>


        <div class="bg-gray-50 p-4 border-2 border-dashed border-gray-300 rounded-md space-y-2">
            <div class="w-full h-24 flex items-center justify-center cursor-pointer {{ isset($ebook) ? 'border-none' : 'border-2 border-dashed' }}"
                @click.native="$refs.fileInput.click()">
                <input type="file" hidden wire:model="ebook" x-ref="fileInput" accept=".epub,.pdf,.txt" />
                <div class="flex flex-col text-center ">

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
                        Click here to select a file
                    @endif


                </div>
            </div>
        </div>
        <button class="w-full py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-md" type="submit">
            Submit
        </button>
    </form>
</div>

