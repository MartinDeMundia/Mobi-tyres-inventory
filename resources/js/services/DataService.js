import http from "../http-common";

class DataService {
  getAll(path, param=0) {
    if(param > 0){
      return http.get("/"+path+"/"+param);
    }else{
      return http.get("/"+path);
    }   
  }

  get(path, id) {
    return http.get("/"+path+"/"+param);
  }

  create(path, data) {
    return http.post("/"+path+"", data);
  }

  update(path, id, data) {
    return http.put(path + `/${id}`, data);
  }

  delete(path, id) {
    return http.delete(`/`+path+`/${id}`);
  }

  deleteAll(path) {
    return http.delete(`/`+path);
  }

  findByParameter(path, search) {
    return http.get(`/`+path+`?search=${search}`);
  }
}

export default new DataService();