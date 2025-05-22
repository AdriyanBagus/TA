<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Program Studi') }} {{ Auth::user()->name }}
      </h2>
  </x-slot>

  <?php
  $menu = App\Models\Menu::get();
  ?>
  <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="container-fluid py-4">
                <div class="row">
                  @foreach ($menu as $item)
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ route($item->link) }}">
                          <div class="card m-2">
                              <div class="card-body p-3">
                                <div class="row">
                                  <div class="col-14">
                                    <div class="numbers">
                                      <p class="font-sans text-sm mb-0 text-uppercase text-black font-weight-bold">{{ $item->menu_id }}</p>
                                      <p class="font-sans text-sm mb-0 text-black font-medium">{{ $item->menu }}</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
