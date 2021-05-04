FROM golang:1.16-alpine as builder

WORKDIR /app

COPY . .

ENV CGO_ENABLED=0

RUN go build -o worker main.go

FROM alpine:latest

WORKDIR /app

ENV PORT=3000

COPY --from=builder /app/worker .

CMD ["./worker"]
