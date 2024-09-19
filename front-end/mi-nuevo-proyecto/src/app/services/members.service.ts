import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MembersService {

  private apiUrl = 'http://localhost:8000/miembro.controller.php';

  constructor(private http: HttpClient) {}

  getMiembros(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}?op=todos`);
  }

  createMiembro(miembro: any): Observable<any> {
    const formData = new FormData();
    console.log(miembro);
    formData.append('id', miembro.miembro_id);
    formData.append('nombre', miembro.nombre);
    formData.append('apellido', miembro.apellido);
    formData.append('email', miembro.email);
    formData.append('telefono', miembro.telefono);
    formData.append('club_id', miembro.club);

    return this.http.post<any>(`${this.apiUrl}?op=insertar`, formData);
  }

  updateMiembro(miembro: any): Observable<any> {
    const formData = new FormData();
    console.log(miembro);
    formData.append('id', miembro.miembro_id);
    formData.append('nombre', miembro.nombre);
    formData.append('apellido', miembro.apellido);
    formData.append('email', miembro.email);
    formData.append('telefono', miembro.telefono);
    formData.append('club_id', miembro.club_id);

    return this.http.post<any>(`${this.apiUrl}?op=actualizar`, formData);
  }

  deleteMiembro(id: number): Observable<any> {
    const formData = new FormData();
    formData.append('id', id.toString());

    return this.http.post<any>(`${this.apiUrl}?op=eliminar`, formData);
  }

  getmiembroById(id: number): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}?op=uno`, new FormData().append('id', id.toString()));
  }
}
