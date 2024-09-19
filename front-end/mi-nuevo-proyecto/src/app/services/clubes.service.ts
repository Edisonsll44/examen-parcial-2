import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClubesService {


  private apiUrl = 'http://localhost:8000/clubes.controller.php?op=todos';

  constructor(private http: HttpClient) {}

  getClubes(): Observable<any> {
    return this.http.get(this.apiUrl);
  }
}
