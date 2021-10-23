<template>
	<div>
		<Nav></Nav>

		<div class="container" v-if="!state.add && !state.edit">
			<div class="card mt-4">
				<div class="card-header">
					Bus
				</div>

				<div class="card-body">
					<button type="button" class="btn btn-primary" @click="state.add = true">Add Bus</button>
					<table class="table mt-4">
						<thead>
							<tr>
								<th>ID</th>
								<th>Plate Number</th>
								<th>Brand</th>
								<th>Seat</th>
								<th>Price Per Day</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="bus in buses" :key="bus.id">
								<td>{{ bus.id }}</td>
								<td>{{ bus.plate_number }}</td>
								<td>{{ bus.brand }}</td>
								<td>{{ bus.seat }}</td>
								<td>{{ bus.price_per_day }}</td>
								<td>
									<button type="button" class="btn btn-sm btn-info mr-1" @click="state.edit = true; editData = bus">Edit</button>
									<button type="button" class="btn btn-sm btn-danger" @click="destroy(bus.id)">Delete</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="container" v-if="state.add">
			<div class="card mt-4">
				<div class="card-header">
					Create Bus
				</div>
				<div class="card-body">
					<form @submit.prevent="create">
						<div class="form-group">
							<label for="plate-number">Plate Number</label>
							<input type="text" class="form-control" id="plate-number" name="plate_number" placeholder="Enter plate number" v-model="formData.plate_number">
						</div>
						<div class="form-group">
							<label for="brand">Brand</label>
							<select id="brand" class="form-control" name="brand" v-model="formData.brand">
								<option value="" hidden>-- Select Brand --</option>
								<option value="mercedes">Mercedes</option>
								<option value="fuso">Fuso</option>
								<option value="scania">Scania</option>
							</select>
						</div>
						<div class="form-group">
							<label for="seat">Seat</label>
							<input type="text" class="form-control" id="seat" name="seat" placeholder="Enter seat capacity" v-model="formData.seat">
						</div>
						<div class="form-group">
							<label for="price-per-day">Price per day</label>
							<input type="text" class="form-control" id="price-per-day" name="price_per_day" placeholder="Enter price per day" v-model="formData.price_per_day">
						</div>

						<button type="submit" class="btn btn-primary mr-1">Add Bus</button>
						<button type="button" class="btn btn-danger" @click="state.add = false">Cancel</button>
					</form>
				</div>
			</div>
		</div>

		<div class="container" v-if="state.edit">
			<div class="card mt-4">
				<div class="card-header">
					Edit Bus
				</div>
				<div class="card-body">
					<form @submit.prevent="update">
						<div class="form-group">
							<label for="plate-number">Plate Number</label>
							<input type="text" class="form-control" id="plate-number" name="plate_number" placeholder="Enter plate number" v-model="editData.plate_number">
						</div>
						<div class="form-group">
							<label for="brand">Brand</label>
							<select id="brand" class="form-control" name="brand" v-model="editData.brand">
								<option value="" hidden>-- Select Brand --</option>
								<option value="mercedes">Mercedes</option>
								<option value="fuso">Fuso</option>
								<option value="scania">Scania</option>
							</select>
						</div>
						<div class="form-group">
							<label for="seat">Seat</label>
							<input type="text" class="form-control" id="seat" name="seat" placeholder="Enter seat capacity" v-model="editData.seat">
						</div>
						<div class="form-group">
							<label for="price-per-day">Price per day</label>
							<input type="text" class="form-control" id="price-per-day" name="price_per_day" placeholder="Enter price per day" v-model="editData.price_per_day">
						</div>

						<button type="submit" class="btn btn-primary mr-1">Save</button>
						<button type="button" class="btn btn-danger" @click="state.edit = false">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import Nav from '@/components/Nav.vue'

export default {
	components: {
		Nav
	},
	data() {
		return {
			header: {
				headers: {
					Authorization: `Bearer ${localStorage.getItem('token')}`
				}
			},
			buses: {},
			state: {
				add: false,
				edit: false
			},
			formData: {
				plate_number: '',
				brand: '',
				seat: '',
				price_per_day: ''
			},
			editData: {}
		}
	},
	methods: {
		getBuses() {
			axios.get(`buses`, this.header)
				.then(res => {
					this.buses = res.data;
				})
				.catch(err => {
					alert(err.response.data.message);
				});
		},
		create() {
			axios.post(`buses`, this.formData, this.header)
				.then(res => {
					this.formData.plate_number = '';
					this.formData.brand = '';
					this.formData.seat = '';
					this.formData.price_per_day = '';
					this.state.add = false;

					this.getBuses();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		},
		update() {
			axios.put(`buses/${this.editData.id}`, this.editData, this.header)
				.then(res => {
					this.editData.plate_number = '';
					this.editData.brand = '';
					this.editData.seat = '';
					this.editData.price_per_day = '';
					this.state.edit = false;

					this.getBuses();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		},
		destroy(id) {
			axios.delete(`buses/${id}`, this.header)
				.then(res => {
					this.getBuses();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		}
	},
	created() {
		this.getBuses();
	}
}
</script>