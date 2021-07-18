<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('post.index') }}" method="get">
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="inputSortCase" class="form-label">Kategori:</label>
                        <select id="inputSortCase" class="form-select" name="tags">
                            <option value="barang" @if(Request::input('tags') == 'barang') selected @endif>Barang</option>
                            <option value="kendaraan" @if(Request::input('tags') == 'kendaraan') selected @endif>Kendaraan</option>
                            <option value="orang" @if(Request::input('tags') == 'orang') selected @endif>Orang</option>
                            <option value="semua" @if(Request::input('tags') == 'semua' || empty(Request::input('tags'))) selected @endif>Semua</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputSortCase" class="form-label">Kategori:</label>
                        <select id="inputSortCase" class="form-select" name="status">
                            <option value="hilang" @if(Request::input('status') == 'hilang') selected @endif>Hilang</option>
                            <option value="temu" @if(Request::input('status') == 'temu') selected @endif>Ditemukan</option>
                            <option value="semua" @if(Request::input('status') == 'semua' || empty(Request::input('status'))) selected @endif>Semua</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputSortCase" class="form-label">Urut Sesuai:</label>
                        <select id="inputSortCase" class="form-select" name="sort">
                            <option value="kasus" @if(Request::input('sort') == 'kasus') selected @endif>Nomor Kasus</option>
                            <option value="tanggal" @if(Request::input('sort') == 'tanggal' || empty(Request::input('status'))) selected @endif>Tanggal Pembuatan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Urutkan Dari:</label>
                        <select id="inputState" class="form-select" name="order">
                            <option value="asc" @if(Request::input('order') == 'asc') selected @endif>ASC (A ke Z)</option>
                            <option value="desc" @if(Request::input('order') == 'desc' || empty(Request::input('order'))) selected @endif>DESC (Z ke A)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
