import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClubesService {
  private apiUrl = 'http://localhost:8000/clubes.controller.php';

  constructor(private http: HttpClient) {}

  getClubes(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}?op=todos`);
  }

  createClub(club: any): Observable<any> {
    const formData = new FormData();
    formData.append('nombre', club.nombre);
    formData.append('deporte', club.deporte);
    formData.append('ubicacion', club.ubicacion);
    formData.append('fecha_fundacion', club.fecha_fundacion);

    return this.http.post<any>(`${this.apiUrl}?op=insertar`, formData);
  }

  updateClub(club: any): Observable<any> {
    const formData = new FormData();
    console.log(club);
    formData.append('id', club.id);
    formData.append('nombre', club.nombre);
    formData.append('deporte', club.deporte);
    formData.append('ubicacion', club.ubicacion);
    formData.append('fecha_fundacion', club.fecha_fundacion);

    return this.http.post<any>(`${this.apiUrl}?op=actualizar`, formData);
  }

  deleteClub(id: number): Observable<any> {
    const formData = new FormData();
    formData.append('id', id.toString());

    return this.http.post<any>(`${this.apiUrl}?op=eliminar`, formData);
  }

  getClubById(id: number): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}?op=uno`, new FormData().append('id', id.toString()));
  }
}
