<template>
	<div>
		<Nav></Nav>

		<div class="container" v-if="!state.add && !state.edit">
			<div class="card mt-4">
				<div class="card-header">
                    Driver
                </div>

				<div class="card-body">
					<button type="button" class="btn btn-primary" @click="state.add = true">Add Driver</button>
					<table class="table mt-4">
						<thead>
							<tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>ID Number</th>
                                <th>Action</th>
                            </tr>
						</thead>
						<tbody>
							<tr v-for="driver in drivers" :key="driver.id">
								<td>{{ driver.id }}</td>
								<td>{{ driver.name }}</td>
								<td>{{ driver.age }}</td>
								<td>{{ driver.id_number }}</td>
								<td>
									<button type="button" class="btn btn-sm btn-info mr-1" @click="state.edit = true; editData = driver">Edit</button>
									<button type="button" class="btn btn-sm btn-danger" @click="destroy(driver.id)">Delete</button>
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
                    Create Driver
                </div>
				<div class="card-body">
					<form @submit.prevent="create">
						<div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" v-model="formData.name">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age" placeholder="Enter name" v-model="formData.age">
                        </div>
                        <div class="form-group">
                            <label for="id-number">ID Number</label>
                            <input type="text" class="form-control" id="id-number" name="id_number" placeholder="Enter id number" v-model="formData.id_number">
                        </div>

						<button type="submit" class="btn btn-primary mr-1">Add Driver</button>
						<button type="button" class="btn btn-danger" @click="state.add = false">Cancel</button>
					</form>
				</div>
			</div>
		</div>

		<div class="container" v-if="state.edit">
			<div class="card mt-4">
				<div class="card-header">
					Edit Driver
				</div>
				<div class="card-body">
					<form @submit.prevent="update">
						<div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" v-model="editData.name">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age" placeholder="Enter name" v-model="editData.age">
                        </div>
                        <div class="form-group">
                            <label for="id-number">ID Number</label>
                            <input type="text" class="form-control" id="id-number" name="id_number" placeholder="Enter id number" v-model="editData.id_number">
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
			drivers: {},
			state: {
				add: false,
				edit: false
			},
			formData: {
				name: '',
				age: '',
				id_number: ''
			},
			editData: {}
		}
	},
	methods: {
		getDrivers() {
			axios.get(`drivers`, this.header)
				.then(res => {
					this.drivers = res.data;
				})
				.catch(err => {
					alert(err.response.data.message);
				});
		},
		create() {
			axios.post(`drivers`, this.formData, this.header)
				.then(res => {
					this.formData.name = '';
					this.formData.age = '';
					this.formData.id_number = '';
					this.state.add = false;

					this.getDrivers();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		},
		update() {
			axios.put(`drivers/${this.editData.id}`, this.editData, this.header)
				.then(res => {
					this.editData.name = '';
					this.editData.age = '';
					this.editData.id_number = '';
					this.state.edit = false;

					this.getDrivers();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		},
		destroy(id) {
			axios.delete(`drivers/${id}`, this.header)
				.then(res => {
					this.getDrivers();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		}
	},
	created() {
		this.getDrivers();
	}
}
</script>