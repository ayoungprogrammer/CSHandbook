// Copyright 2010 The Go Authors. All rights reserved.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

package main

import (
    "fmt"
    "os"
    "html/template"
    "io/ioutil"
    "net/http"
    "strings"
    //"regexp"
)

type Page struct {
    Title string
    Body []byte
}


func get(w http.ResponseWriter, r *http.Request){
    fmt.Printf("GET: %s\n",r.URL.Path[1:])
    file := "public/"+r.URL.Path[1:]
    if _, err := os.Stat(file); err == nil {
        //http.Redirect(w,r,"")
    }
    http.ServeFile(w,r,file)

}

func loadPage(title string)(*Page, error){
    filename := "data/"+title + ".txt"
    body, err := ioutil.ReadFile(filename)
    if err != nil {
        return nil,err
    }
    return &Page{Title:title,Body:body} ,nil
}

func getPathData(path string)(string){
    return path[strings.Index(path[1:],"/")+2:]
}

var templates = template.Must(template.ParseFiles( "views/view.html"))
func view(w http.ResponseWriter,r *http.Request){
    path := getPathData(r.URL.Path)
    p, err := loadPage(path)
    fmt.Printf("VIEW: %s\n",path)
    if err != nil{
        http.Redirect(w,r,"/edit/"+path,http.StatusFound)
        return
    }
    renderTemplate(w,"view",p)
}

func renderTemplate(w http.ResponseWriter, template string,p *Page){
    err := templates.ExecuteTemplate(w, template+".html",p)
    if err != nil{
        http.Error(w, err.Error(),http.StatusInternalServerError)
    }
}

func main() {
    fmt.Printf("Running webserver\n")
    http.HandleFunc("/",get);
    http.HandleFunc("/view/",view);
    http.ListenAndServe(":8080", nil)
}
