package main

import (
	"fmt"
	"log"
	"net/http"
	"os"
	"rsc.io/quote"
)

type helloHandler struct{}

func (h helloHandler) ServeHTTP(w http.ResponseWriter, r *http.Request) {
	w.WriteHeader(200)
	w.Write([]byte(fmt.Sprintf("Hello World %s", r.Referer())))
	log.Printf("URL: %s | UserAgent: %s | Referer: %s", r.URL, r.UserAgent(), r.Referer())
}

func main() {
	fmt.Println(quote.Go())

	addr := fmt.Sprintf(":%s", os.Getenv("PORT"))

	fmt.Println(fmt.Sprintf("Starting the HTTP Server on %s", addr))

	http.ListenAndServe(addr, helloHandler{})
}
