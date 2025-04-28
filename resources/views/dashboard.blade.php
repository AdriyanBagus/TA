<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }} {{ Auth::user()->name }}
      </h2>
  </x-slot>

  <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="container-fluid py-4">
                  <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ route('pages.visi_misi') }}">
                          <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Analisis Visi Misi</p>
                                    <h5 class="font-weight-bolder">
                                      {{ $tabelCounts['tabel1'] }}
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span> 2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ route('pages.kerjasama_pendidikan') }}">
                          <div class="card">
                              <div class="card-body p-3">
                                <div class="row">
                                  <div class="col-8">
                                    <div class="numbers">
                                      <p class="text-xs mb-0 text-uppercase font-weight-bold">Kerjasama Pendidikan</p>
                                      <h5 class="font-weight-bolder">
                                        {{ $tabelCounts['tabel2'] }}
                                      </h5>
                                      <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"></span>
                                        2025
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </a>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ route('pages.kerjasama_penelitian') }}">
                          <div class="card">
                              <div class="card-body p-3">
                                <div class="row">
                                  <div class="col-8">
                                    <div class="numbers">
                                      <p class="text-xs mb-0 text-uppercase font-weight-bold">Kerjasama Penelitian</p>
                                      <h5 class="font-weight-bolder">
                                        {{ $tabelCounts['tabel3'] }}
                                      </h5>
                                      <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"></span>
                                        2025
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </a>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ route('pages.kerjasama_pengabdian_kepada_masyarakat') }}">
                          <div class="card">
                              <div class="card-body p-3">
                                <div class="row">
                                  <div class="col-8">
                                    <div class="numbers">
                                      <p class="text-xs mb-0 text-uppercase font-weight-bold">Kerjasama Pengabdian Kepada Masyarakat</p>
                                      <h5 class="font-weight-bolder">
                                        {{ $tabelCounts['tabel4'] }}
                                      </h5>
                                      <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"></span>
                                        2025
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </a>
                    </div>
                  </div>
              </div>

              <div class="container-fluid py-4">
                <div class="row">
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.ketersediaan_dokumen') }}">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-xs mb-0 text-uppercase font-weight-bold">Ketersediaan Dokumen</p>
                                  <h5 class="font-weight-bolder">
                                    2
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder"></span> 2025
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.evaluasi_pelaksanaan') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Evaluasi Pelaksanaan</p>
                                    <h5 class="font-weight-bolder">
                                      {{ $tabelCounts['tabel5'] }}
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.profil_dosen') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Profil Dosen</p>
                                    <h5 class="font-weight-bolder">
                                      {{ $tabelCounts['tabel6'] }}
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.beban_kinerja_dosen') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Beban Kinerja Dosen</p>
                                    <h5 class="font-weight-bolder">
                                      {{ $tabelCounts['tabel7'] }}
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                </div>
              </div>

              <div class="container-fluid py-4">
                <div class="row">
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.profil_dosen_tidak_tetap') }}">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-xs mb-0 text-uppercase font-weight-bold">Profil Dosen Tidak Tetap</p>
                                  <h5 class="font-weight-bolder">
                                    {{ $tabelCounts['tabel8'] }}
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder"></span> 2025
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.pelaksanaan_ta') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Pelaksanaan TA</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.lahan_praktek') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Lahan Praktek</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.kinerja_dtps') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Kinerja DTPS</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                </div>
              </div>

              <div class="container-fluid py-4">
                <div class="row">
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.profil_tenaga_kependidikan') }}">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-xs mb-0 text-uppercase font-weight-bold">Profil Tenaga Kependidikan</p>
                                  <h5 class="font-weight-bolder">
                                    2
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder"></span> 2025
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.rekognisi_tenaga_kependidikan') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Rekognisi Tenaga Kependidikan</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.penelitian_dosen') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Penelitian Dosen</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a href="{{ route('pages.penelitian_mahasiswa') }}">
                        <div class="card">
                            <div class="card-body p-3">
                              <div class="row">
                                <div class="col-8">
                                  <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Penelitian Mahasiswa</p>
                                    <h5 class="font-weight-bolder">
                                      2
                                    </h5>
                                    <p class="mb-0">
                                      <span class="text-success text-sm font-weight-bolder"></span>
                                      2025
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </a>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
