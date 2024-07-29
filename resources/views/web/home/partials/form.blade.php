			<form action="" method="GET" class="d-none d-lg-block">
				<div class="form-group">
                    <div class="input-group">
                    	<div class="form-floating">
                        	<input type="text" name="address" aria-label="Adres" class="form-control input-lg" placeholder="Adres (ulica i nr domu)" @if(request()->address !== null) value="{{ request()->address }}" @else value="{{ old('address') }}" @endif required>
                        	<label for="address">Adres (ulica i nr domu)</label>
                        </div>
                        <div class="form-floating">
                        	<input type="text" name="city" aria-label="Miejscowość" class="form-control input-lg" placeholder="Miejscowość" @if(request()->city !== null) value="{{ request()->city }}" @else value="{{ old('city') }}" @endif required>
                        	<label for="city">Miejscowość</label>
                        </div>
                        <div class="form-floating">
                        	<input type="text" name="distance" aria-label="Miejscowość" class="form-control input-lg" placeholder="Szukaj w promieniu (km)" @if(request()->distance !== null) value="{{ request()->distance }}" @else value="{{ old('distance') }}" @endif required>
                        	<label for="distance">Szukaj w promieniu (km)</label>
                        </div>
						<button type="submit" class="btn btn-lg btn-danger"><i class="fa fa-search"></i>&nbsp;Szukaj</button>
                    </div>
				</div>
				<input type="hidden" name="lat" @if(request()->lat !== null) value="{{ request()->lat }}" @endif />
				<input type="hidden" name="lng" @if(request()->lng !== null) value="{{ request()->lng }}" @endif/>
			</form>
			<form action="" method="GET" class="d-lg-none text-center">
				<div class="form-floating mb-3">
                    <input type="text" name="address" aria-label="Adres" class="form-control input-lg" placeholder="Adres (ulica i nr domu)" @if(request()->address !== null) value="{{ request()->address }}" @else value="{{ old('address') }}" @endif required>
                	<label for="address">Adres (ulica i nr domu)</label>
                </div>
				<div class="form-floating mb-3">
					<input type="text" name="city" aria-label="Miejscowość" class="form-control input-lg" placeholder="Miejscowość" @if(request()->city !== null) value="{{ request()->city }}" @else value="{{ old('city') }}" @endif required>
					<label for="city">Miejscowość</label>
				</div>	
				<div class="form-floating mb-3">
					<input type="text" name="distance" aria-label="Miejscowość" class="form-control input-lg" placeholder="Szukaj w promieniu (km)" @if(request()->distance !== null) value="{{ request()->distance }}" @else value="{{ old('distance') }}" @endif required>
					<label for="distance">Szukaj w promieniu (km)</label>
				</div>
				<button type="submit" class="btn btn-lg btn-danger"><i class="fa fa-search"></i>&nbsp;Szukaj</button>
                        
				<input type="hidden" name="lat" @if(request()->lat !== null) value="{{ request()->lat }}" @endif />
				<input type="hidden" name="lng" @if(request()->lng !== null) value="{{ request()->lng }}" @endif/>
			</form>	