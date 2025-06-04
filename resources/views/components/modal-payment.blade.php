<!-- Main modal -->
<div id="select-modal-pembayaran" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    Pilih Pembayaran
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal-pembayaran">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <ul class="space-y-4 mb-4 flex flex-col">
                    <li>
                        <input type="radio" id="pay-1" name="job" value="pay-1" class="hidden peer" required />
                        <label for="pay-1" class="w-full inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-amber-900  peer-checked:text-amber-900 hover:text-amber-900 hover:bg-gray-100 ">                           
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('assets/images/logo_qris.svg') }}" alt="Empty Star" class="w-1/8">
                                <div class="payment_info_text">
                                    <div class="w-full text-lg">QRIS</div>
                                    <div class="w-full text-gray-500 ">Scan QRIS</div>
                                </div>
                                <svg class=" ml-auto w-3 h-3 ms-3 rtl:rotate-180 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="pay-2" name="job" value="pay-2" class="hidden peer" required />
                        <label for="pay-2" class="w-full inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-amber-900  peer-checked:text-amber-900 hover:text-amber-900 hover:bg-gray-100 ">                           
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('assets/images/logo_money.png') }}" alt="Empty Star" class="w-1/8">
                                <div class="payment_info_text">
                                    <div class="w-full text-lg">Uang Digital</div>
                                    <div class="w-full text-gray-500 ">Gopay/Shopee/Dana</div>
                                </div>
                                <svg class=" ml-auto w-3 h-3 ms-3 rtl:rotate-180 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="pay-3" name="job" value="pay-3" class="hidden peer" required />
                        <label for="pay-3" class="w-full inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-amber-900  peer-checked:text-amber-900 hover:text-amber-900 hover:bg-gray-100 ">                           
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('assets/images/logo_bca.png') }}" alt="Empty Star" class="w-1/8">
                                <div class="payment_info_text">
                                    <div class="w-full text-lg">Bank BCA</div>
                                    <div class="w-full text-gray-500 ">Bank BCA - Virtual Account</div>
                                </div>
                                <svg class=" ml-auto w-3 h-3 ms-3 rtl:rotate-180 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="pay-4" name="job" value="pay-4" class="hidden peer" required />
                        <label for="pay-4" class="w-full inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-amber-900  peer-checked:text-amber-900 hover:text-amber-900 hover:bg-gray-100 ">                           
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('assets/images/logo_bri.png') }}" alt="Empty Star" class="w-1/8">
                                <div class="payment_info_text">
                                    <div class="w-full text-lg">Bank BRI</div>
                                    <div class="w-full text-gray-500 ">Bank BRI - Virtual Account</div>
                                </div>
                                <svg class=" ml-auto w-3 h-3 ms-3 rtl:rotate-180 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </div>
                        </label>
                    </li>
                </ul>
                <button class="text-white inline-flex w-full justify-center bg-[#534538] hover:bg-[#362d24] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                    Next step
                </button>
            </div>
        </div>
    </div>
</div> 
